#!/usr/bin/env node
'use strict';
const fs = require('fs');
const path = require('path');

const root = path.resolve(__dirname, '..');
const targets = [
  '_build/assets/tour/audio/en',
  '_build/assets/tour/audio/hi',
  '_build/assets/tour/audio/mr',
  'tools/voice_pack/en',
  'tools/voice_pack/hi',
  'tools/voice_pack/mr',
  'tools/voice_pack/generated.json'
];

for (const relative of targets) {
  const absolute = path.resolve(root, relative);
  if (!absolute.startsWith(root + path.sep)) throw new Error('Unsafe cleanup target: ' + absolute);
  if (fs.existsSync(absolute)) {
    fs.rmSync(absolute, { recursive: true, force: true });
    console.log('Removed ' + relative);
  }
}
fs.mkdirSync(path.resolve(root, '_build/assets/tour/audio/mr'), { recursive: true });
console.log('Created empty Marathi audio destination.');
