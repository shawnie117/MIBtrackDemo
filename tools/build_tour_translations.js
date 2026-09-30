#!/usr/bin/env node
'use strict';

/*
 * Build the Hindi and English tour narration from the exact approved Marathi
 * narration already extracted from the supplied Word document. Paragraphs
 * are translated independently so the 23-step structure and paragraph order
 * cannot drift. The Marathi source is copied byte-for-byte into the output.
 */

const fs = require('fs');
const path = require('path');
const vm = require('vm');

const root = path.resolve(__dirname, '..');
const contentPath = path.join(root, '_build', 'assets', 'js', 'demo-tour-content.js');
const outputPath = path.join(root, 'tools', 'demo-tour-translations.json');

const sandbox = { window: {} };
vm.runInNewContext(fs.readFileSync(contentPath, 'utf8'), sandbox);
const steps = sandbox.window.MIB_TOUR_CONTENT.full;

async function translateParagraph(text, target) {
  const url = new URL('https://translate.googleapis.com/translate_a/single');
  url.searchParams.set('client', 'gtx');
  url.searchParams.set('sl', 'mr');
  url.searchParams.set('tl', target);
  url.searchParams.set('dt', 't');
  url.searchParams.set('q', text);
  const response = await fetch(url, { headers: { 'User-Agent': 'MI-BTrack demo translation builder' } });
  if (!response.ok) throw new Error(`Translation ${target} failed with HTTP ${response.status}`);
  const data = await response.json();
  return data[0].map(part => part[0]).join('').trim();
}

async function translateStep(step, target) {
  const paragraphs = step.text.mr.split(/\n\n+/);
  const translated = [];
  for (const paragraph of paragraphs) translated.push(await translateParagraph(paragraph, target));
  return translated.join('\n\n');
}

(async () => {
  const output = {};
  for (const step of steps) {
    process.stdout.write(`${step.id} `);
    output[step.id] = {
      mr: step.text.mr,
      hi: await translateStep(step, 'hi'),
      en: await translateStep(step, 'en')
    };
    console.log('ok');
  }
  fs.writeFileSync(outputPath, JSON.stringify(output, null, 2) + '\n', 'utf8');
  console.log(`Wrote ${steps.length} aligned translations to ${outputPath}`);
})().catch(error => {
  console.error(error.stack || error.message);
  process.exit(1);
});
