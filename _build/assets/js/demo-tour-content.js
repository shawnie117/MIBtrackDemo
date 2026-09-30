/* AUTO-GENERATED from DEMO_FULL_SHORT_TEXT_PLAN.md and tools/demo-tour-translations.json.
 * Run: node tools/build_full_demo_content.js
 * Marathi narration is copied exactly from the approved document plan; Hindi and English are aligned translations.
 */
(function (w) {
  'use strict';
  var full = [
  {
    "id": "f01",
    "chapter": {
      "mr": "F01",
      "hi": "F01",
      "en": "F01"
    },
    "url": "vendor/dashboard",
    "selector": ".page-content",
    "title": {
      "mr": "Dashboard introduction",
      "hi": "Dashboard introduction",
      "en": "Dashboard introduction"
    },
    "text": {
      "mr": "हा आपला MI-Btrack CRM चा डॅशबोर्ड आहे.",
      "hi": "यह आपका MI-Btrack CRM का डैशबोर्ड है।",
      "en": "This is your dashboard of MI-Btrack CRM."
    }
  },
  {
    "id": "f02",
    "chapter": {
      "mr": "F02",
      "hi": "F02",
      "en": "F02"
    },
    "url": "vendor/masters/add_sale_product",
    "selector": "#pdt_name",
    "title": {
      "mr": "Masters Add New Sale Product",
      "hi": "Masters Add New Sale Product",
      "en": "Masters Add New Sale Product"
    },
    "text": {
      "mr": "सर्वप्रथम आपण आपले जे काही प्रोडक्ट सेल करत आहोत, ते आपण Masters मध्ये जाऊन Add New Sale Product मध्ये ॲड करून घेऊयात.",
      "hi": "सबसे पहले हम जो भी प्रोडक्ट बेच रहे हैं उसे मास्टर्स पर जाकर Add New Sale Product में जोड़ लें।",
      "en": "First of all, whatever product we are selling, let's go to Masters and add it to Add New Sale Product."
    },
    "cue": [
      {
        "id": "select-0",
        "kind": "select",
        "selector": "#p_brand_id",
        "at": 0.05,
        "label": "Black Hit"
      },
      {
        "id": "type-1",
        "kind": "type",
        "selector": "#pdt_name",
        "at": 0.12,
        "value": "Rat Repellent"
      },
      {
        "id": "click-2",
        "kind": "click",
        "selector": "#pdt_desc",
        "at": 0.23
      },
      {
        "id": "type-3",
        "kind": "type",
        "selector": "#pdt_desc",
        "at": 0.23,
        "value": "Rat repellent for pest control"
      },
      {
        "id": "type-4",
        "kind": "type",
        "selector": "#pdt_regular_price",
        "at": 0.36,
        "value": "1500"
      },
      {
        "id": "type-5",
        "kind": "type",
        "selector": "#pdt_comm_price",
        "at": 0.45,
        "value": "1200"
      },
      {
        "id": "type-6",
        "kind": "type",
        "selector": "#pdt_warranty_period",
        "at": 0.54,
        "value": "365"
      },
      {
        "id": "type-7",
        "kind": "type",
        "selector": "#p_noofservices",
        "at": 0.64,
        "value": "2"
      },
      {
        "id": "focus-8",
        "kind": "focus",
        "selector": "#p_sit",
        "at": 0.72
      },
      {
        "id": "type-9",
        "kind": "type",
        "selector": "#pdt_gst",
        "at": 0.8,
        "value": "18"
      },
      {
        "id": "focus-10",
        "kind": "focus",
        "selector": "#mybutton",
        "at": 0.91
      }
    ]
  },
  {
    "id": "f03",
    "chapter": {
      "mr": "F03",
      "hi": "F03",
      "en": "F03"
    },
    "url": "vendor/masters/add_amc",
    "selector": "#amc_name",
    "title": {
      "mr": "Masters Add New AMC",
      "hi": "Masters Add New AMC",
      "en": "Masters Add New AMC"
    },
    "text": {
      "mr": "त्यानंतर आपण Master Section मध्ये जाऊन Add New AMC मध्ये AMC ॲड करून ठेवूयात. AMC मध्ये आपण ज्या काही सर्विसेस कस्टमर्सला देत आहोत, ज्या काही AMC देत आहोत, त्या सर्व AMC त्यामध्ये ॲड करून ठेवणार आहोत.",
      "hi": "उसके बाद हम मास्टर सेक्शन में जाते हैं और Add New AMC में AMC जोड़ते हैं। एएमसी में, हम उन सभी सेवाओं को जोड़ने जा रहे हैं जो हम ग्राहकों को प्रदान कर रहे हैं, सभी एएमसी जो हम प्रदान कर रहे हैं।",
      "en": "After that we go to Master Section and add AMC in Add New AMC. In AMC, we are going to add all the services we are providing to the customers, all the AMCs we are providing."
    },
    "cue": [
      {
        "id": "type-0",
        "kind": "type",
        "selector": "#amc_name",
        "at": 0.12,
        "value": "General Pest Management"
      },
      {
        "id": "click-1",
        "kind": "click",
        "selector": "#amc_desc",
        "at": 0.25
      },
      {
        "id": "type-2",
        "kind": "type",
        "selector": "#amc_desc",
        "at": 0.25,
        "value": "GPMS AMC for 1 year"
      },
      {
        "id": "type-3",
        "kind": "type",
        "selector": "#amc_duration",
        "at": 0.36,
        "value": "365"
      },
      {
        "id": "type-4",
        "kind": "type",
        "selector": "#amc_noofservices",
        "at": 0.45,
        "value": "6"
      },
      {
        "id": "focus-5",
        "kind": "focus",
        "selector": "#amc_sit",
        "at": 0.54
      },
      {
        "id": "type-6",
        "kind": "type",
        "selector": "#amc_gst",
        "at": 0.63,
        "value": "18"
      },
      {
        "id": "type-7",
        "kind": "type",
        "selector": "#amc_price",
        "at": 0.72,
        "value": "2000"
      },
      {
        "id": "type-8",
        "kind": "type",
        "selector": "#amc_corporate_price",
        "at": 0.81,
        "value": "1900"
      },
      {
        "id": "focus-9",
        "kind": "focus",
        "selector": "#mybutton",
        "at": 0.91
      }
    ]
  },
  {
    "id": "f04",
    "chapter": {
      "mr": "F04",
      "hi": "F04",
      "en": "F04"
    },
    "url": "vendor/masters/add_one_time_service",
    "selector": "#ots_name",
    "title": {
      "mr": "Masters Add New OTS",
      "hi": "Masters Add New OTS",
      "en": "Masters Add New OTS"
    },
    "text": {
      "mr": "त्यानंतर आपण ज्या काही One-Time Services देत आहोत, त्या आपण Masters मध्ये जाऊन Add New OTS मध्ये ॲड करणार आहोत.",
      "hi": "उसके बाद, हम मास्टर्स में जा रहे हैं और ऐड न्यू ओटीएस में हम जो वन-टाइम सेवाएं प्रदान कर रहे हैं उन्हें जोड़ देंगे।",
      "en": "After that, we are going to go to Masters and add the One-Time Services that we are providing in Add New OTS."
    },
    "cue": [
      {
        "id": "type-0",
        "kind": "type",
        "selector": "#ots_name",
        "at": 0.08,
        "value": "General OTS"
      },
      {
        "id": "click-1",
        "kind": "click",
        "selector": "#ots_type",
        "at": 0.22
      },
      {
        "id": "type-2",
        "kind": "type",
        "selector": "#ots_type",
        "at": 0.22,
        "value": "One time service"
      },
      {
        "id": "type-3",
        "kind": "type",
        "selector": "#ots_desc",
        "at": 0.36,
        "value": "For cleaning service at one time"
      },
      {
        "id": "type-4",
        "kind": "type",
        "selector": "#ots_gst",
        "at": 0.52,
        "value": "18"
      },
      {
        "id": "type-5",
        "kind": "type",
        "selector": "#price_regular",
        "at": 0.65,
        "value": "500"
      },
      {
        "id": "type-6",
        "kind": "type",
        "selector": "#price_comm",
        "at": 0.78,
        "value": "700"
      },
      {
        "id": "focus-7",
        "kind": "focus",
        "selector": "#mybutton",
        "at": 0.91
      }
    ]
  },
  {
    "id": "f05",
    "chapter": {
      "mr": "F05",
      "hi": "F05",
      "en": "F05"
    },
    "url": "vendor/masters/add_reference",
    "selector": "#ref_name",
    "title": {
      "mr": "Masters Add New Reference",
      "hi": "Masters Add New Reference",
      "en": "Masters Add New Reference"
    },
    "text": {
      "mr": "त्यानंतर आपल्याला कस्टमरचे रेफरन्सेस कुठून जास्त येत आहेत, हे कळण्यासाठी आपण आपले References हे Master Section मध्ये जाऊन Add New Reference मध्ये ॲड करून घेऊयात.",
      "hi": "उसके बाद, यह जानने के लिए कि हमें अधिक ग्राहक संदर्भ कहां से मिल रहे हैं, आइए मास्टर अनुभाग पर जाएं और नए संदर्भ जोड़ने के लिए अपने संदर्भ जोड़ें।",
      "en": "After that, to know from where we are getting more customer references, let's go to the Master Section and add our References to Add New Reference."
    },
    "cue": [
      {
        "id": "type-0",
        "kind": "type",
        "selector": "#ref_name",
        "at": 0.8,
        "value": "Google"
      }
    ]
  },
  {
    "id": "f06",
    "chapter": {
      "mr": "F06",
      "hi": "F06",
      "en": "F06"
    },
    "url": "vendor/dashboard",
    "selector": ".page-content",
    "title": {
      "mr": "Leads introduction and Add New Lead",
      "hi": "Leads introduction and Add New Lead",
      "en": "Leads introduction and Add New Lead"
    },
    "text": {
      "mr": "आपल्याला ज्या कुठल्याही प्लॅटफॉर्ममधून लीड्स येत आहेत, जसे की Just Dial, IndiaMart, Meta Ads, Google किंवा आपण कोणतेही कॅम्पेन रन करत असाल, तर तिथून आलेली लीड डायरेक्टली आपल्या CRM मध्ये येईल. ती लीड आपल्याला आपल्या CRM च्या डॅशबोर्डवरती दिसेल की ती लीड आपल्याला कुठल्या प्लॅटफॉर्मवरून आलेली आहे. किंवा आपल्याला लीड मॅन्युअली ॲड करायची असेल, तर आपण Leads मध्ये जाऊन Add New Lead मध्ये ती लीड ॲड करून घेऊयात.",
      "hi": "जिस भी प्लेटफॉर्म से आपको लीड मिल रही है जैसे जस्ट डायल, इंडियामार्ट, मेटा एड्स, गूगल या आप कोई कैंपेन चला रहे हैं तो वहां से लीड सीधे आपके सीआरएम में आ जाएगी। आप उस लीड को अपने CRM डैशबोर्ड पर देखेंगे कि वह लीड किस प्लेटफ़ॉर्म से आपके पास आई थी। या यदि आप मैन्युअल रूप से लीड जोड़ना चाहते हैं, तो हमें लीड्स पर जाना चाहिए और उस लीड को Add New Lead में जोड़ना चाहिए।",
      "en": "Any platform from which you are getting leads like Just Dial, IndiaMart, Meta Ads, Google or if you are running any campaign, the lead from there will directly come into your CRM. You will see that lead on your CRM dashboard from which platform that lead came to you. Or if you want to add the lead manually, then we should go to Leads and add that lead in Add New Lead."
    },
    "cue": [
      {
        "id": "navigate-0",
        "kind": "navigate",
        "selector": "vendor/leads/add_lead",
        "at": 0.86,
        "target": "#lead_name"
      },
      {
        "id": "type-1",
        "kind": "type",
        "selector": "#lead_name",
        "at": 0.93,
        "value": "Ambar Patil"
      }
    ]
  },
  {
    "id": "f07",
    "chapter": {
      "mr": "F07",
      "hi": "F07",
      "en": "F07"
    },
    "url": "vendor/leads/add_lead",
    "selector": "[data-target=\"#reference_section\"]",
    "title": {
      "mr": "Lead details and business value",
      "hi": "Lead details and business value",
      "en": "Lead details and business value"
    },
    "text": {
      "mr": "लीड ॲड करताना आपल्याला ती लीड कुठून आली आहे, हे देखील आपण Reference मध्ये सिलेक्ट करून घेऊ शकतो. म्हणजे ती लीड आपल्याला IndiaMart वरून आली आहे, Instagram वरून आली आहे किंवा Google वरून आली आहे, हे आपण सिलेक्ट करू शकतो. त्यानंतर, लीड ॲड करताना आपण Alternate Contact Numbers देखील ॲड करू शकतो. जेणेकरून जेव्हा कस्टमर अवेलेबल नसेल, तेव्हा आपण त्याच्या Alternate Contact Number वरती कॉल करू शकतो. म्हणजेच, जर मुख्य कॉन्टॅक्ट नंबरवर कस्टमर अवेलेबल नसेल, तर आपण अल्टर्नेट कॉन्टॅक्ट नंबरवरती कॉल करू शकतो. रिफरन्स ॲड केल्यामुळे आपल्याला एक आयडिया कळते की आपला ROI किती आहे. जेणेकरून आपल्याला समजते की आपल्याला जास्त बिझनेस कुठून येत आहे, कोणत्या प्लॅटफॉर्मवरून जास्त लीड्स किंवा बिझनेस मिळत आहे. त्यानुसार आपण त्या प्लॅटफॉर्मवर मार्केटिंगसाठी पैसे वगैरे इन्व्हेस्ट करू शकतो. लीड्स ॲड करताना Enquiry For मध्ये आपल्याला ती लीड कोणत्या सर्विससाठी आली आहे, हे आपण तिथे टाकू शकतो. जेणेकरून आपल्याला एक आयडिया मिळेल की कोणत्या सर्विसेससाठी आपल्याला जास्त लीड्स येत आहेत",
      "hi": "लीड जोड़ते समय, हम संदर्भ में यह भी चुन सकते हैं कि लीड कहाँ से आई है। इसका मतलब है कि हम यह चुन सकते हैं कि लीड इंडियामार्ट, इंस्टाग्राम या गूगल से आई है। फिर, लीड जोड़ते समय हम वैकल्पिक संपर्क नंबर भी जोड़ सकते हैं। ताकि जब ग्राहक उपलब्ध न हो तो हम उसके वैकल्पिक संपर्क नंबर पर कॉल कर सकें। यानी, अगर ग्राहक मुख्य संपर्क नंबर पर उपलब्ध नहीं है, तो हम वैकल्पिक संपर्क नंबर पर कॉल कर सकते हैं। संदर्भ जोड़ने से आपको अंदाज़ा हो जाता है कि आपका ROI क्या है। ताकि हम समझ सकें कि हमें कहां से ज्यादा बिजनेस मिल रहा है, किस प्लेटफॉर्म से हमें ज्यादा लीड या बिजनेस मिल रहा है। उस हिसाब से हम उस प्लेटफॉर्म पर मार्केटिंग के लिए पैसा आदि निवेश कर सकते हैं। लीड जोड़ते समय हम उस सेवा को Enquiry For में डाल सकते हैं जिसके लिए लीड आई है। जिससे आपको अंदाजा हो जाए कि आपको किस सर्विस के लिए ज्यादा लीड मिल रही है",
      "en": "While adding a lead, we can also select where the lead came from in Reference. That means we can select whether the lead came from IndiaMart, Instagram or Google. Then, while adding leads we can also add Alternate Contact Numbers. So that when the customer is not available, we can call on his Alternate Contact Number. That is, if the customer is not available on the main contact number, we can call on the alternate contact number. Adding references gives you an idea of ​​what your ROI is. So that we understand where we are getting more business from, from which platform we are getting more leads or business. Accordingly we can invest money etc. for marketing on that platform. While adding leads, we can enter the service for which the lead has come in Inquiry For. So that you get an idea for which services you are getting more leads"
    },
    "cue": [
      {
        "id": "type-0",
        "kind": "type",
        "selector": "#lead_name",
        "at": 0,
        "value": "Ambar Patil"
      },
      {
        "id": "type-1",
        "kind": "type",
        "selector": "#lead_contact",
        "at": 0,
        "value": "4515554454"
      },
      {
        "id": "type-2",
        "kind": "type",
        "selector": "#lead_desc",
        "at": 0,
        "value": "New amc required"
      },
      {
        "id": "select-3",
        "kind": "select",
        "selector": "#lead_priority",
        "at": 0,
        "label": "High"
      },
      {
        "id": "type-4",
        "kind": "type",
        "selector": "#company_name",
        "at": 0,
        "value": "ABC Industries"
      },
      {
        "id": "expand-5",
        "kind": "expand",
        "selector": "[data-target=\"#additional_details\"]",
        "at": 0.01,
        "target": "#additional_details"
      },
      {
        "id": "expand-6",
        "kind": "expand",
        "selector": "[data-target=\"#reference_section\"]",
        "at": 0.03,
        "target": "#reference_section"
      },
      {
        "id": "select-7",
        "kind": "select",
        "selector": "#lead_refby",
        "at": 0.11,
        "label": "Google"
      },
      {
        "id": "expand-8",
        "kind": "expand",
        "selector": "[data-target=\"#alt_contact_section\"]",
        "at": 0.27,
        "target": "#alt_contact_section"
      },
      {
        "id": "type-9",
        "kind": "type",
        "selector": ".lead_altcontact",
        "at": 0.34,
        "value": "4578325451"
      },
      {
        "id": "select-10",
        "kind": "select",
        "selector": "#lead_productid",
        "at": 0.84,
        "label": "General Pest Management"
      }
    ]
  },
  {
    "id": "f08",
    "chapter": {
      "mr": "F08",
      "hi": "F08",
      "en": "F08"
    },
    "url": "vendor/leads/view_lead?id=NzAwOA%3D%3D",
    "selector": "a[title=\"Add Follow-up\"]",
    "title": {
      "mr": "Lead Followup",
      "hi": "Lead Followup",
      "en": "Lead Followup"
    },
    "text": {
      "mr": "लीड ॲड केल्यानंतर आपण त्या लीडचा फॉलो-अप घेऊ शकतो, जेणेकरून ती लीड आपल्या कस्टमरमध्ये कन्वर्ट होईल. यासाठी आपल्या त्या लीडसोबत जे काही डिस्कशन झालं आहे, ते आपण फॉलो-अपमध्ये ॲड करून घेऊ शकतो. जेणेकरून उद्या जेव्हा आपल्याला त्या लीडबद्दल पुन्हा बोलायचं असेल, तेव्हा मागच्या वेळेस काय बोलणं झालं होतं, हे आपल्याला लक्षात ठेवायची गरज नाही.",
      "hi": "लीड जोड़ने के बाद, हम उस लीड पर फ़ॉलो-अप कर सकते हैं, ताकि लीड हमारे ग्राहक में परिवर्तित हो जाए। इसके लिए, हम उस लीड के साथ जो भी चर्चा करेंगे उसे फॉलो-अप में जोड़ सकते हैं। ताकि कल जब हम उस लीड के बारे में दोबारा बात करना चाहें तो हमें यह याद न रखना पड़े कि पिछली बार क्या कहा गया था।",
      "en": "After adding a lead, we can follow-up on that lead, so that the lead converts into our customer. For this, we can add whatever discussion we have with that lead in the follow-up. So that when we want to talk about that lead again tomorrow, we don't have to remember what was said last time."
    },
    "cue": [
      {
        "id": "click-0",
        "kind": "click",
        "selector": "a[title=\"Add Follow-up\"]",
        "at": 0.05
      },
      {
        "id": "type-1",
        "kind": "type",
        "selector": "#followup_feedback",
        "at": 0.44,
        "value": "Need Followup"
      }
    ]
  },
  {
    "id": "f09",
    "chapter": {
      "mr": "F09",
      "hi": "F09",
      "en": "F09"
    },
    "url": "vendor/dashboard",
    "selector": ".page-content",
    "title": {
      "mr": "Lead follow-up dashboard result",
      "hi": "Lead follow-up dashboard result",
      "en": "Lead follow-up dashboard result"
    },
    "text": {
      "mr": "फॉलो-अप प्रॉपरली ॲड केल्याने आपली ती लीड लूज होण्याचे चान्सेस कमी असतात. आपण त्या लीड्सच्या कन्स्टंट कॉन्टॅक्टमध्ये राहतो, जेणेकरून ती लीड आपल्या कस्टमरमध्ये कन्वर्ट होण्यास मदत होते आणि कन्वर्जनचे चान्सेस जास्त असतात. CRM चा डॅशबोर्ड ओपन केल्यावर आपल्याला तिथे डॅशबोर्डवरती दिसेल की आपल्याला आज किती लीड्सचे फॉलो-अप्स घ्यायचे आहेत आणि किती कस्टमर्सचे आज फॉलो-अप्स घ्यायचे आहेत. लीड्स आणि फॉलो-अप मॅनेजमेंटमुळे आपला जो काही बिझनेस आहे, तो प्रोसेस डिपेंडंट होतो.",
      "hi": "Follow-Up ठीक से जोड़ने पर उस Lead के छूट जाने की संभावना कम हो जाती है। हम Leads के लगातार संपर्क में रहते हैं, जिससे उस Lead को Customer में Convert करने में मदद मिलती है और Conversion की संभावना बढ़ती है। CRM का Dashboard खोलने पर हमें दिखाई देता है कि आज कितनी Leads के Follow-Ups लेने हैं और कितने Customers के Follow-Ups लेने हैं। Leads और Follow-Up Management से हमारा Business प्रक्रिया पर निर्भर बनता है।",
      "en": "By following-up properly your chances of losing that lead are less. We stay in constant contact with those leads, so that leads convert into our customers and chances of conversion are high. After opening the dashboard of CRM, you will see on the dashboard how many leads you want to follow up today and how many customers you want to follow up today. Leads and follow-up management make whatever business you have, process dependent."
    },
    "cue": [
      {
        "id": "focus-0",
        "kind": "focus",
        "selector": ".todays-my-followups",
        "at": 0.49
      }
    ]
  },
  {
    "id": "f10",
    "chapter": {
      "mr": "F10",
      "hi": "F10",
      "en": "F10"
    },
    "url": "vendor/customers/add_customer",
    "selector": "#cust_name",
    "title": {
      "mr": "Customers Add New Customer",
      "hi": "Customers Add New Customer",
      "en": "Customers Add New Customer"
    },
    "text": {
      "mr": "त्यानंतर आपण कस्टमर्स ॲड करून ठेवूयात. Customers मध्ये Add New Customer मध्ये जाऊयात. त्यानंतर आपण कस्टमरचे सर्व डिटेल्स यामध्ये एंटर करून ठेवूयात. Service Type मध्ये AMC सिलेक्ट करूयात आणि GST Option मध्ये With GST सिलेक्ट करूयात. त्यानंतर कस्टमरचा GST नंबर असेल, तर तोही आपण टाकू शकतो. त्यानंतर कस्टमरचे नाव आपण टाकून घेऊयात, त्यांचा कॉन्टॅक्ट नंबर आणि ईमेल आयडी असे सर्व डिटेल्स आपण इथे फिल करून घेऊयात. कस्टमरचा ॲड्रेसदेखील आपण यात टाकू शकतो. कस्टमर कधी ॲड झालेला आहे, हे आपण Customer Added Date मध्ये टाकून घेऊयात. त्यानंतर खाली आलेल्या सर्विसेसमधून जी काही AMC आपण त्याला देत आहोत, ती AMC आपण सिलेक्ट करून घेऊयात. AMC ची जी काही रक्कम आहे, ती अमाऊंट इथे येते. जर आपल्याला ती एडिट करायची असेल, तर तेही आपण इथून करू शकतो. आपण कस्टमरला ज्या दिवशी सर्विस देत आहोत, ती दिनांक जर आपल्याला चेंज करायची असेल, तर तेही आपण चेंज करू शकतो. कस्टमरने जर पेमेंट ऑलरेडी केलेलं असेल, तर Paid Amount जी काही असेल, ती आपण Payment Mode मध्ये Cash, Online जे काही असेल ते सिलेक्ट करून तिथे अमाऊंट टाकू शकतो. त्यानंतर या कस्टमरचा आपल्याला Reference By ॲड करायचा असेल, तर तोही आपण इथे ॲड करू शकतो. Alternate Contact Numbers वगैरे आपण ॲड करू शकतो, जेणेकरून कस्टमर जर अवेलेबल नसेल, तर अल्टरनेट कॉन्टॅक्ट नंबरवर कॉल करता येईल. त्यानंतर आपण तो कस्टमर Submit करून देऊयात.",
      "hi": "उसके बाद हम ग्राहक जोड़ेंगे. चलिए Customers में Add New Customer पर चलते हैं. इसके बाद हम ग्राहक की सारी डिटेल इसमें डाल देंगे. सर्विस टाइप में एएमसी चुनें और जीएसटी विकल्प में विद जीएसटी चुनें। इसके बाद अगर ग्राहक के पास जीएसटी नंबर है तो हम उसे भी डाल सकते हैं. इसके बाद हम ग्राहक का नाम लेंगे, उनका कॉन्टैक्ट नंबर और ईमेल आईडी जैसी सारी जानकारी यहां भरेंगे। हम ग्राहक का पता भी दर्ज कर सकते हैं। जब ग्राहक जुड़ जाता है, तो उसे Customer Added Date में डाल देते हैं। उसके बाद, हम निम्नलिखित सेवाओं में से उस एएमसी का चयन करेंगे जो हम उसे दे रहे हैं। जितनी भी एएमसी होती है, वह रकम यहां आती है। अगर हम इसे संपादित करना चाहते हैं, तो हम यहां से ऐसा कर सकते हैं। जिस तारीख को हम ग्राहक को सेवा प्रदान कर रहे हैं यदि हम उसे बदलना चाहें तो वह भी बदल सकते हैं। यदि ग्राहक ने पहले ही भुगतान कर दिया है, तो भुगतान राशि जो भी हो, हम भुगतान मोड में नकद, ऑनलाइन का चयन कर सकते हैं और वहां राशि दर्ज कर सकते हैं। उसके बाद अगर हम इस ग्राहक का Reference By जोड़ना चाहें तो उसे भी यहां जोड़ सकते हैं. हम वैकल्पिक संपर्क नंबर आदि जोड़ सकते हैं, ताकि यदि ग्राहक उपलब्ध नहीं है, तो वैकल्पिक संपर्क नंबर पर कॉल किया जा सके। उसके बाद हम उस ग्राहक को सबमिट कर देंगे.",
      "en": "After that we will add customers. Let's go to Add New Customer in Customers. After that we will enter all the details of the customer in it. Select AMC in Service Type and select With GST in GST Option. After that, if the customer has GST number, we can also enter it. After that we will take the name of the customer, we will fill all the details like their contact number and email id here. We can also enter the address of the customer. When the customer is added, let's put it in Customer Added Date. After that, we will select the AMC that we are giving him from the following services. Any amount of AMC, that amount comes here. If we want to edit it, we can do that from here. If we want to change the date on which we are providing service to the customer, we can change that too. If the customer has already made the payment, then whatever the Paid Amount is, we can select Cash, Online in the Payment Mode and enter the amount there. After that, if we want to add Reference By of this customer, we can also add it here. We can add Alternate Contact Numbers etc., so that if the customer is not available, then the alternate contact number can be called. After that we will submit that customer."
    },
    "cue": [
      {
        "id": "select-0",
        "kind": "select",
        "selector": "#cust_service_type",
        "at": 0.13,
        "label": "AMC"
      },
      {
        "id": "select-1",
        "kind": "select",
        "selector": "#cust_gst_type",
        "at": 0.17,
        "label": "With GST"
      },
      {
        "id": "type-2",
        "kind": "type",
        "selector": "#cust_gstno",
        "at": 0.22,
        "value": "XXXXXXXX1234"
      },
      {
        "id": "type-3",
        "kind": "type",
        "selector": "#cust_name",
        "at": 0.27,
        "value": "Adinath Mhaske"
      },
      {
        "id": "type-4",
        "kind": "type",
        "selector": "#cust_contact",
        "at": 0.3,
        "value": "4152488895"
      },
      {
        "id": "type-5",
        "kind": "type",
        "selector": "#cust_contact_email",
        "at": 0.33,
        "value": "aadinath@gmail.com"
      },
      {
        "id": "type-6",
        "kind": "type",
        "selector": "#cust_address",
        "at": 0.38,
        "value": "Swastik niwas, khandagale vasti, Mumbai."
      },
      {
        "id": "date-7",
        "kind": "date",
        "selector": "#cust_ui_date",
        "at": 0.43
      },
      {
        "id": "type-8",
        "kind": "type",
        "selector": "#amcSearch",
        "at": 0.46,
        "value": "General Pest Management"
      },
      {
        "id": "click-9",
        "kind": "click",
        "selector": "#tbl_service_id input[type=\"checkbox\"][value=\"4009\"]",
        "at": 0.49
      },
      {
        "id": "click-10",
        "kind": "click",
        "selector": ".btn-show-services",
        "at": 0.51
      },
      {
        "id": "focus-11",
        "kind": "focus",
        "selector": "#serviceModal1 #tbl_service_details tr",
        "at": 0.53
      },
      {
        "id": "click-12",
        "kind": "click",
        "selector": "#serviceModal1 button.close",
        "at": 0.62
      },
      {
        "id": "focus-13",
        "kind": "focus",
        "selector": "#cust_total_amount",
        "at": 0.65
      },
      {
        "id": "select-14",
        "kind": "select",
        "selector": "#full_payment_section #company_pay_type",
        "at": 0.7,
        "label": "Cash"
      },
      {
        "id": "type-15",
        "kind": "type",
        "selector": "#full_payment_section #cust_paid_amount",
        "at": 0.74,
        "value": "1000"
      },
      {
        "id": "select-16",
        "kind": "select",
        "selector": "#cust_refbyid",
        "at": 0.82,
        "label": "Google"
      },
      {
        "id": "type-17",
        "kind": "type",
        "selector": "#alt_cust_contact",
        "at": 0.88,
        "value": "2254632584"
      }
    ]
  },
  {
    "id": "f11",
    "chapter": {
      "mr": "F11",
      "hi": "F11",
      "en": "F11"
    },
    "url": "vendor/customers/view_customer?id=NjAxMw%3D%3D",
    "selector": ".followuptbl:has(a[title=\"Click To Schedule\"])",
    "title": {
      "mr": "Customer services and dashboard",
      "hi": "Customer services and dashboard",
      "en": "Customer services and dashboard"
    },
    "text": {
      "mr": "कस्टमर सबमिट झाल्यानंतर ज्या काही AMC सर्विसेस आपण कस्टमरला देत आहोत, त्या आपल्याला खाली दिसतील. ती सर्विस जर कंप्लेंटची असेल, तर आपण तिथे Cancel Service करून Completed Reason टाकून ती सर्विस सबमिट करू शकतो. किंवा जर ही सर्विस आपल्याला शेड्युल करायची असेल आणि कोणाला टास्क असाइन करायचा असेल, तर आपण Schedule मध्ये क्लिक करून, Schedule या बटनावर क्लिक करून ती सर्विस शेड्युल करू शकतो. आपण जर डॅशबोर्डवरती जाऊन चेक केलं, तर आपल्याला Pending Services मध्ये आपण कस्टमर क्रिएट केलेला आहे, त्याची सर्विस दाखवेल की या कस्टमरची सर्विस बाकी आहे. मग आपण त्या कस्टमरवरती क्लिक करून त्याची सर्विस आपण Complete करू शकतो. त्यानंतर आपण या कस्टमरबद्दल जे काही फॉलो-अप असेल, ते फॉलो-अप्सदेखील खाली Add Follow-ups मध्ये जाऊन ॲड करू शकतो. आणि जर पेमेंट नंतर आले असेल, तर Payment या बटनवरती क्लिक करून आपण ते पेमेंट देखील ॲड करू शकतो. ज्या कोणत्या कस्टमरचे पेमेंट पेंडिंग आहे, ते देखील आपल्याला डॅशबोर्डवरती Payment Defaulters असे दिसेल.",
      "hi": "नीचे कुछ एएमसी सेवाएं दी गई हैं जो हम ग्राहक के सबमिशन के बाद ग्राहक को प्रदान कर रहे हैं। यदि वह सेवा शिकायत के लिए है, तो हम वहां सेवा रद्द कर सकते हैं और पूर्ण कारण दर्ज करके उस सेवा को सबमिट कर सकते हैं। या फिर अगर हम इस सर्विस को शेड्यूल करना चाहते हैं और किसी को कोई कार्य सौंपना चाहते हैं तो हम शेड्यूल बटन पर क्लिक करके उस सर्विस को शेड्यूल कर सकते हैं। यदि आप डैशबोर्ड पर जाकर चेक करते हैं कि आपने पेंडिंग सर्विसेज में एक ग्राहक बनाया है तो इसकी सर्विस से पता चल जाएगा कि इस ग्राहक की सर्विस पेंडिंग है। फिर हम उस ग्राहक पर क्लिक करके सेवा पूरी कर सकते हैं। फिर हम नीचे फॉलो-अप जोड़ें पर जाकर इस ग्राहक के बारे में कोई भी फॉलो-अप जोड़ सकते हैं। और अगर पेमेंट बाद में आती है तो हम पेमेंट बटन पर क्लिक करके उस पेमेंट को भी जोड़ सकते हैं। जिन ग्राहकों का भुगतान लंबित है, उन्हें आप डैशबोर्ड पर भुगतान डिफॉल्टर के रूप में भी देखेंगे।",
      "en": "Below are some of the AMC services we are providing to the customer after customer submission. If that service is for complaint, then we can cancel service there and submit that service by entering Completed Reason. Or if we want to schedule this service and assign a task to someone, then we can schedule that service by clicking on the Schedule button. If you go to the dashboard and check, you have created a customer in Pending Services, its service will show that the service of this customer is pending. Then we can complete the service by clicking on that customer. Then we can add any follow-ups about this customer by going below to Add Follow-ups. And if the payment comes later, then we can add that payment too by clicking on the Payment button. Customers whose payment is pending, you will also see as Payment Defaulters on the dashboard."
    },
    "cue": [
      {
        "id": "focus-0",
        "kind": "focus",
        "selector": "button[onclick^=\"openCompleteServiceModal\"]",
        "at": 0.13
      },
      {
        "id": "focus-1",
        "kind": "focus",
        "selector": "a[title=\"Click To Schedule\"]",
        "at": 0.28
      },
      {
        "id": "navigate-2",
        "kind": "navigate",
        "selector": "vendor/dashboard",
        "at": 0.42,
        "target": ".pending-services-reminder"
      },
      {
        "id": "navigate-3",
        "kind": "navigate",
        "selector": "vendor/customers/view_customer?id=NjAxMw%3D%3D",
        "at": 0.64,
        "target": "a[title=\"Add Follow-up\"]"
      },
      {
        "id": "focus-4",
        "kind": "focus",
        "selector": "a[title=\"Make Payment\"]",
        "at": 0.72
      },
      {
        "id": "navigate-5",
        "kind": "navigate",
        "selector": "vendor/dashboard",
        "at": 0.91,
        "target": ".payment-defaulter-reminder"
      }
    ]
  },
  {
    "id": "f12",
    "chapter": {
      "mr": "F12",
      "hi": "F12",
      "en": "F12"
    },
    "url": "vendor/customers/view_customer?id=NjAxMw%3D%3D",
    "selector": "[title*=\"Download Invoice\"]",
    "title": {
      "mr": "Customer invoice and WhatsApp explanation",
      "hi": "Customer invoice and WhatsApp explanation",
      "en": "Customer invoice and WhatsApp explanation"
    },
    "text": {
      "mr": "आपण क्रिएट केलेल्या कस्टमरवरती जर आपण चेक केले, तर आपण जी काही सर्विसेस कस्टमरला देत आहोत, त्याचे Invoice ऑटोमॅटिकली क्रिएट होते. ते आपण डाउनलोड करून कस्टमर्सला शेअर करू शकतो. जर आपल्याला कस्टमर्सला CRM च्या माध्यमातून WhatsApp Messages सेंड करायचे असतील, तर आपण आपली WhatsApp API Key आम्हाला प्रोव्हाइड केल्यास, आम्ही आपल्याला ते इंटिग्रेट करून देऊ. जेणेकरून आपण कस्टमर्सला CRM मधूनच Messages सेंड करू शकाल. इनव्हॉइसमध्ये आपल्या कंपनीचा लोगो, QR कोड आणि बँक डिटेल्स हे सर्व आपल्या अकाऊंटमध्ये एडिट करता येतात.",
      "hi": "यदि आप अपने द्वारा बनाए गए ग्राहक की जांच करते हैं, तो आपके द्वारा ग्राहक को प्रदान की जा रही सेवाओं के लिए चालान स्वचालित रूप से बनाया जाता है। हम इसे डाउनलोड कर सकते हैं और ग्राहकों के साथ साझा कर सकते हैं। यदि आप सीआरएम के माध्यम से ग्राहकों को व्हाट्सएप संदेश भेजना चाहते हैं, तो यदि आप हमें अपनी व्हाट्सएप एपीआई कुंजी प्रदान करते हैं, तो हम इसे आपके लिए एकीकृत करेंगे। ताकि आप CRM से ही ग्राहकों को संदेश भेज सकें। चालान में आपकी कंपनी का लोगो, क्यूआर कोड और बैंक विवरण शामिल हैं जो आपके खाते में संपादन योग्य हैं।",
      "en": "If you check on the customer you have created, the invoice is automatically created for the services you are providing to the customer. We can download it and share it with customers. If you want to send WhatsApp messages to customers through CRM, then if you provide us with your WhatsApp API Key, we will integrate it for you. So that you can send messages to customers from CRM itself. Invoices include your company logo, QR code and bank details all editable in your account."
    }
  },
  {
    "id": "f13",
    "chapter": {
      "mr": "F13",
      "hi": "F13",
      "en": "F13"
    },
    "url": "vendor/customers/view_customer?id=NjAxMw%3D%3D",
    "selector": "a[title=\"Add Follow-up\"]",
    "title": {
      "mr": "Customer Followup",
      "hi": "Customer Followup",
      "en": "Customer Followup"
    },
    "text": {
      "mr": "त्यानंतर कस्टमरचा आपण प्रॉपर असा फॉलो-अप घेऊ शकतो, जेणेकरून त्या कस्टमरला आपल्याला वेळेवर सर्विसेस देता येतील. Follow-Up या बटनावरती क्लिक करून आपण Follow-Up Details मध्ये जी काही सर्विस द्यायची आहे, ती ॲड करू शकतो. त्याच्या Follow-Up Status मध्ये आपण Pending असे करू शकतो. त्यानंतर Follow-Up For मध्ये Routine आणि Follow-Up Medium मध्ये Visit वगैरे जे काही ऑप्शन आपल्याला सुटेबल असेल, ते यूज करून आपण फॉलो-अप मॅनेज करू शकतो. त्यानंतर Next Follow-Up Date and Time मध्ये आपण जी काही Date आणि Time सेट करू, त्या डेटला आपल्याला डॅशबोर्डवरती Pending Follow-Ups मध्ये त्या कस्टमरचं नाव दिसेल. जेणेकरून आपल्याला कळेल की या कस्टमरचा आज फॉलो-अप घ्यायचा आहे.",
      "hi": "उसके बाद हम ग्राहक का उचित फॉलो-अप ले सकते हैं, ताकि हम उस ग्राहक को समय पर सेवाएं प्रदान कर सकें। फॉलो-अप बटन पर क्लिक करके, हम फॉलो-अप विवरण में कोई भी सेवा जोड़ सकते हैं जो हम प्रदान करना चाहते हैं। इसके फॉलोअप स्टेटस में हम पेंडिंग बना सकते हैं. उसके बाद, जो भी विकल्प हमारे लिए उपयुक्त हो, जैसे रूटीन इन फॉलो-अप फॉर और विजिट इन फॉलो-अप मीडियम का उपयोग करके हम फॉलो-अप का प्रबंधन कर सकते हैं। उसके बाद हम नेक्स्ट फॉलो-अप डेट और टाइम में जो भी तारीख और समय सेट करेंगे, उस डेट पर हमें डैशबोर्ड पर पेंडिंग फॉलो-अप में उस ग्राहक का नाम दिखाई देगा। ताकि आप जान सकें कि इस ग्राहक को आज फॉलो-अप की आवश्यकता है।",
      "en": "After that we can take proper follow-up of the customer, so that we can provide timely services to that customer. By clicking on the Follow-Up button, we can add any service we want to provide in the Follow-Up Details. In its follow-up status we can make Pending. After that, we can manage the follow-up by using whatever option is suitable for us like Routine in Follow-Up For and Visit in Follow-Up Medium. After that whatever date and time we set in Next Follow-Up Date and Time, on that date we will see the name of that customer in Pending Follow-Ups on the dashboard. So that you know that this customer needs a follow-up today."
    },
    "cue": [
      {
        "id": "click-0",
        "kind": "click",
        "selector": "a[title=\"Add Follow-up\"]",
        "at": 0.05
      },
      {
        "id": "type-1",
        "kind": "type",
        "selector": "#followup_feedback",
        "at": 0.28,
        "value": "service pending"
      },
      {
        "id": "select-2",
        "kind": "select",
        "selector": "#followupstatusid",
        "at": 0.42,
        "label": "Pending"
      },
      {
        "id": "select-3",
        "kind": "select",
        "selector": "#followupfor",
        "at": 0.52,
        "label": "Routine"
      },
      {
        "id": "click-4",
        "kind": "click",
        "selector": "#visitRadio",
        "at": 0.58
      },
      {
        "id": "dateTime-5",
        "kind": "dateTime",
        "selector": "#next_update_date",
        "at": 0.75
      }
    ]
  },
  {
    "id": "f14",
    "chapter": {
      "mr": "F14",
      "hi": "F14",
      "en": "F14"
    },
    "url": "vendor/admin/add_employee",
    "selector": "#emp_name",
    "title": {
      "mr": "Employee Add New Employee",
      "hi": "Employee Add New Employee",
      "en": "Employee Add New Employee"
    },
    "text": {
      "mr": "आपले जे काही टेक्निशियन, फिल्ड वर्कर्स वगैरे आहेत, तर त्यांचे लोकेशन विथ टायमिंग ट्रॅक करण्यासाठी आपण Employee Attendance आणि Employee Location Tracking हे फीचर्स CRM मध्ये यूज केलेले आहेत. तर त्यासाठी आपण सगळ्यात पहिले आपले जे काही सर्व Employees आहेत, ते Create करून घ्यायचे आहेत. तर Employee मध्ये Add New Employee या सेक्शनमध्ये जाऊन तेथे आपल्याला आपल्या Employee चे सर्व डिटेल्स टाकायचे आहेत. जसे की Employee चे नाव, Employee चा Contact Number, ते Employee कोणाला Report करतात, त्यांचे Designation काय आहे, जसे की Employee आहे, Sales Person आहे, Technician आहे का किंवा त्याला आपल्याला Admin बनवायचा आहे, ते Designation आपण Choose करायचे. Employee च्या Designation नुसार त्याला Permissions Assign होतात. म्हणजेच त्याला आपण जे काही Permissions देऊ, त्यानुसार त्याचा Dashboard Visible करू शकतो आणि त्यानुसार तो आपले CRM Access करू शकतो. त्यानंतर Employee च्या Department मध्ये त्याचे Department टाकायचे आहे. Location Tracking ला Yes करायचा आहे, जेणेकरून आपल्याला Field वरती गेलेल्या Employee चे Location कळेल. त्यानंतर Employee ची Joining Date आणि Address वगैरे टाकून घ्यायचा आहे. आपण आपल्या Employee चे Bank Details देखील Add करू शकतो किंवा त्याचे इतर Details देखील Add करू शकतो. त्यानंतर आपण आपल्या Employee चे Details Submit या Button वरती क्लिक करून Submit करायचे आहे.",
      "hi": "हम अपने तकनीशियनों और फील्ड वर्कर्स की लोकेशन तथा समय ट्रैक करने के लिए CRM में Employee Attendance और Employee Location Tracking फीचर्स का उपयोग करते हैं। इसके लिए सबसे पहले हमें अपने सभी Employees बनाने हैं। Employee में Add New Employee सेक्शन में जाकर Employee की सभी डिटेल्स दर्ज करनी हैं। इनमें Employee का नाम, Contact Number, वह किसे Report करता है और उसका Designation क्या है, जैसी जानकारी शामिल है। Designation में Employee, Sales Person, Technician या Admin में से उपयुक्त विकल्प चुनना है। Employee के Designation के अनुसार उसे Permissions मिलती हैं। हम उसे जो Permissions देंगे, उसी के अनुसार उसका Dashboard दिखाई देगा और वह CRM Access कर सकेगा। इसके बाद Employee का Department दर्ज करना है। Location Tracking को Yes करना है, ताकि Field पर गए Employee की Location पता चल सके। फिर Employee की Joining Date और Address दर्ज करना है। हम Employee की Bank Details और दूसरी डिटेल्स भी Add कर सकते हैं। अंत में Submit बटन पर क्लिक करके Employee की डिटेल्स Submit करनी हैं।",
      "en": "We use the Employee Attendance and Employee Location Tracking features in the CRM to track the location and timing of our technicians and field workers. For this, we first need to create all our Employees. Go to the Add New Employee section under Employee and enter all the Employee details. These include the Employee name, Contact Number, whom the Employee Reports to, and the Employee's Designation. Choose the appropriate Designation, such as Employee, Sales Person, Technician, or Admin. Permissions are assigned according to the Employee's Designation. The Dashboard will be visible and the Employee will be able to Access the CRM according to the Permissions we provide. Next, enter the Employee's Department. Set Location Tracking to Yes so that we can see the Location of an Employee who has gone into the Field. Then enter the Employee's Joining Date and Address. We can also Add the Employee's Bank Details and other details. Finally, click the Submit button to Submit the Employee details."
    },
    "cue": [
      {
        "id": "type-0",
        "kind": "type",
        "selector": "#emp_name",
        "at": 0.18,
        "value": "Prajyot"
      },
      {
        "id": "type-1",
        "kind": "type",
        "selector": "#emp_mob1",
        "at": 0.24,
        "value": "8546951251"
      },
      {
        "id": "focus-2",
        "kind": "focus",
        "selector": "#emp_rpt_to",
        "at": 0.3
      },
      {
        "id": "select-3",
        "kind": "select",
        "selector": "#permission_id",
        "at": 0.34,
        "label": "Employee"
      },
      {
        "id": "select-4",
        "kind": "select",
        "selector": "#department_id",
        "at": 0.62,
        "label": "Servicing"
      },
      {
        "id": "select-5",
        "kind": "select",
        "selector": "#location_tracking",
        "at": 0.7,
        "value": "Yes"
      },
      {
        "id": "type-6",
        "kind": "type",
        "selector": "#emp_joining_date",
        "at": 0.77,
        "value": "12/12/2012"
      },
      {
        "id": "type-7",
        "kind": "type",
        "selector": "#emp_address",
        "at": 0.81,
        "value": "kiran apartment, Shambhu nagar, Mumbai."
      },
      {
        "id": "focus-8",
        "kind": "focus",
        "selector": "#emp_bank_account_name",
        "at": 0.86
      },
      {
        "id": "focus-9",
        "kind": "focus",
        "selector": "#mybutton",
        "at": 0.94
      }
    ]
  },
  {
    "id": "f15",
    "chapter": {
      "mr": "F15",
      "hi": "F15",
      "en": "F15"
    },
    "url": "vendor/admin/employee_report",
    "selector": ".portlet.light.bordered",
    "title": {
      "mr": "Employee credentials and attendance",
      "hi": "Employee credentials and attendance",
      "en": "Employee credentials and attendance"
    },
    "text": {
      "mr": "त्यानंतर All Employees Report मध्ये आपण जो काही Employee Create केलेला आहे, त्याच्या नावावरती क्लिक करून त्याचे Details Open होतील. त्यामध्ये त्याचा User ID आणि Password असेल. तर User ID आणि Password त्या Employee ला शेअर करायचा. अशाच प्रकारे प्रत्येक Employee चा Unique User ID आणि Password असेल. त्यानंतर आपल्या Employee ला MI-Btrack CRM ही Mobile Android App Play Store वरून Download करायला सांगायचं आहे. Download केल्यानंतर आपला जो Unique Username आणि Password आहे, तो Employee त्या App मध्ये टाकेल. त्यानंतर त्यांना OTP Receive होईल. त्या OTP ला Validate केल्यानंतर आपल्या Employee ला MI-Btrack CRM Application मध्ये त्यांचा Dashboard दिसायला लागेल. मोबाईल ॲप्लिकेशनमध्ये लेफ्ट साईडच्या कॉर्नरला तीन लाईन्स आहेत. त्याच्यावरती क्लिक केल्यानंतर Employee Attendance असा एक ऑप्शन दिसेल. त्या ऑप्शनवरती क्लिक केल्यानंतर तिथे Login आणि Logout हे दोन बटन्स असतील. Login वरती क्लिक करून आपला Selfie काढून Employee ने Attendance Submit करायचे आहे. जेव्हा ते ऑफिसमध्ये येतील किंवा फील्डवरती असतील, तेव्हा तिथून त्यांनी Attendance Mark करायचे आहे. अशाच प्रकारे जेव्हा ते Logout करतील, तेव्हा Logout वरती जाऊन आपला Selfie Upload करून Attendance Submit करायचे आहे. डेस्कटॉपवरती Employee मध्ये Attendance Report या सेक्शनवरती आपण जेव्हा क्लिक करतो, त्यानंतर तिथे आपल्याला आपल्या Employee चा Attendance Report दिसेल. अशा प्रकारे आपण आपल्या Employees ची Daily Attendance चेक करू शकतो किंवा Monthly Attendance Report देखील बघू शकतो आणि तो Download देखील करू शकतो. Attendance मध्ये आपल्या Employee ची Image, Login Time, Logout Time, Login Location आणि Logout Location ही सर्व Details आपल्याला बघायला मिळतील.",
      "hi": "इसके बाद ऑल एम्प्लॉइज रिपोर्ट में आपने जिस कर्मचारी का नाम बनाया है उस पर क्लिक करें और उसकी डिटेल खुल जाएगी। इसमें उसका यूजर आईडी और पासवर्ड होगा। फिर यूजर आईडी और पासवर्ड उस कर्मचारी के साथ साझा किया जाना चाहिए। इसी प्रकार, प्रत्येक कर्मचारी के पास एक अद्वितीय यूजर आईडी और पासवर्ड होगा। फिर अपने कर्मचारी को प्ले स्टोर से एमआई-बीट्रैक सीआरएम मोबाइल एंड्रॉइड ऐप डाउनलोड करने के लिए कहें। डाउनलोड करने के बाद कर्मचारी उस ऐप में आपका यूनिक यूजरनेम और पासवर्ड डालेगा। इसके बाद उन्हें ओटीपी प्राप्त होगा. उस ओटीपी को सत्यापित करने के बाद, आपका कर्मचारी एमआई-बीट्रैक सीआरएम एप्लिकेशन में अपना डैशबोर्ड देखेगा। मोबाइल एप्लिकेशन में बायीं ओर कोने पर तीन लाइनें हैं। इस पर क्लिक करने के बाद Employee Attendance नाम का विकल्प दिखाई देगा। उस विकल्प पर क्लिक करने के बाद वहां दो बटन होंगे लॉगिन और लॉगआउट। कर्मचारी को लॉगइन पर क्लिक कर सेल्फी लेकर उपस्थिति दर्ज करानी होगी। जब वे ऑफिस या फील्ड में आते हैं तो उन्हें वहीं से हाजिरी लगानी होती है. इसी तरह जब वे लॉगआउट करेंगे तो उन्हें लॉगआउट पर जाकर अपनी सेल्फी अपलोड करनी होगी और अटेंडेंस सबमिट करना होगा। जब हम डेस्कटॉप पर कर्मचारी में उपस्थिति रिपोर्ट अनुभाग पर क्लिक करते हैं, तो हमें वहां हमारे कर्मचारी की उपस्थिति रिपोर्ट दिखाई देगी। इस प्रकार हम अपने कर्मचारियों की दैनिक उपस्थिति की जांच कर सकते हैं या मासिक उपस्थिति रिपोर्ट देख सकते हैं और इसे डाउनलोड भी कर सकते हैं। अटेंडेंस में आपको अपने कर्मचारी की इमेज, लॉगइन टाइम, लॉगआउट टाइम, लॉगइन लोकेशन और लॉगआउट लोकेशन जैसी सारी डिटेल्स देखने को मिलेंगी।",
      "en": "After that, click on the name of the employee you have created in the All Employees Report and its details will open. It will contain his User ID and Password. Then User ID and Password should be shared with that Employee. Similarly, each employee will have a unique user ID and password. Then ask your employee to download MI-Btrack CRM Mobile Android App from Play Store. After downloading, the Employee will enter your Unique Username and Password in that App. After that they will receive OTP. After validating that OTP, your employee will see their dashboard in MI-Btrack CRM Application. In the mobile application, there are three lines on the left side corner. After clicking on it, an option called Employee Attendance will appear. After clicking on that option there will be two buttons Login and Logout. Employee has to submit attendance by taking a selfie by clicking on login. When they come to office or field, they have to mark attendance from there. Similarly, when they logout, they have to go to Logout and upload their Selfie and Submit Attendance. When we click on the Attendance Report section in Employee on the desktop, then we will see the Attendance Report of our Employee there. In this way we can check the Daily Attendance of our Employees or view the Monthly Attendance Report and can also download it. In Attendance you will get to see all the details like Image, Login Time, Logout Time, Login Location and Logout Location of your Employee."
    },
    "cue": [
      {
        "id": "navigate-0",
        "kind": "navigate",
        "selector": "vendor/admin/view_employee?id=NTAwNQ%3D%3D",
        "at": 0.04,
        "target": ".portlet.light.bordered"
      },
      {
        "id": "focus-1",
        "kind": "focus",
        "selector": ".page-content table tr:has(th):nth-child(4)",
        "at": 0.11
      },
      {
        "id": "navigate-2",
        "kind": "navigate",
        "selector": "assets/demo-mobile/index.html?screen=login&connected=1",
        "at": 0.26,
        "target": "#mobile-user"
      },
      {
        "id": "type-3",
        "kind": "type",
        "selector": "#mobile-user",
        "at": 0.3,
        "value": "8546951251"
      },
      {
        "id": "type-4",
        "kind": "type",
        "selector": "#mobile-password",
        "at": 0.32,
        "value": "demo123"
      },
      {
        "id": "click-5",
        "kind": "click",
        "selector": "#mobile-login",
        "at": 0.34
      },
      {
        "id": "type-6",
        "kind": "type",
        "selector": "#mobile-otp",
        "at": 0.37,
        "value": "123456"
      },
      {
        "id": "click-7",
        "kind": "click",
        "selector": "#verify-otp",
        "at": 0.4
      },
      {
        "id": "click-8",
        "kind": "click",
        "selector": "#mobile-back",
        "at": 0.45
      },
      {
        "id": "click-9",
        "kind": "click",
        "selector": "#employee-attendance",
        "at": 0.48
      },
      {
        "id": "click-10",
        "kind": "click",
        "selector": "#attendance-login",
        "at": 0.53
      },
      {
        "id": "click-11",
        "kind": "click",
        "selector": "#submit-selfie",
        "at": 0.57
      },
      {
        "id": "click-12",
        "kind": "click",
        "selector": "#attendance-logout",
        "at": 0.64
      },
      {
        "id": "click-13",
        "kind": "click",
        "selector": "#submit-selfie",
        "at": 0.68
      },
      {
        "id": "navigate-14",
        "kind": "navigate",
        "selector": "vendor/admin/emp_attendance_report",
        "at": 0.76,
        "target": ".portlet.light.bordered"
      }
    ],
    "prepare": "attendance_prepare"
  },
  {
    "id": "f16",
    "chapter": {
      "mr": "F16",
      "hi": "F16",
      "en": "F16"
    },
    "url": "vendor/customers/add_ticket",
    "selector": "#tkt_title",
    "title": {
      "mr": "Tickets Add New Ticket",
      "hi": "Tickets Add New Ticket",
      "en": "Tickets Add New Ticket"
    },
    "text": {
      "mr": "लेफ्ट साईडला Tickets मध्ये Add New Ticket मध्ये आपण नवीन Ticket Create करू शकतो, जेणेकरून आपण आपल्या Employees ला Task Assign करू शकतो. त्यामध्ये Customer Type मध्ये आपण Ticket कस्टमर, लीड किंवा दुसऱ्या कोणासाठी Assign करत आहोत, ते Select करायचे. त्यानंतर आपण त्या Customer किंवा Lead चे नाव खाली दिलेल्या Dropdown मध्ये Select करायचे. Ticket Title मध्ये आपण आपल्या Employees ला जे काही Instructions देऊ इच्छितो, त्या Instructions आपण टाकायच्या. Ticket Priority मध्ये हे Ticket Solve करणे किती Priority चे आहे, म्हणजेच High, Medium किंवा Low, ते आपण Select करायचे. त्यानंतर Ticket Description मध्ये Task Resolve करण्यासाठी Employees ला जे काही Details किंवा Description द्यायचे आहे, ते आपण Ticket Description मध्ये टाकायचे. त्यानंतर हे Ticket आपल्याला कोणत्या Employee ला Assign करायचे आहे, ते Ticket Assign मध्ये त्या Employee चे नाव Select करायचे. Ticket आपण कधी Assign केली आहे, त्याची Date आणि Time टाकायची आणि नंतर ते Ticket Submit करायचे.",
      "hi": "बायीं ओर, टिकट्स में, हम ऐड न्यू टिकट में एक नया टिकट बना सकते हैं, ताकि हम अपने कर्मचारियों को कार्य सौंप सकें। उसमें कस्टमर टाइप में सेलेक्ट करें कि हम कस्टमर, लीड या किसी और को टिकट असाइन कर रहे हैं। उसके बाद हमें नीचे दिए गए ड्रॉपडाउन में उस ग्राहक या लीड का नाम चुनना चाहिए। टिकट शीर्षक में हम अपने कर्मचारियों को जो भी निर्देश देना चाहते हैं उसे अवश्य लिखें। टिकट प्राथमिकता में, हमें इस टिकट को हल करने की प्राथमिकता का चयन करना चाहिए, यानी उच्च, मध्यम या निम्न। फिर टिकट विवरण में, कर्मचारियों को टिकट विवरण में कार्य समाधान के लिए जो भी विवरण या विवरण देना है, उसे दर्ज करना चाहिए। इसके बाद आप जिस कर्मचारी को यह टिकट देना चाहते हैं, Ticket Assign में उस कर्मचारी का नाम चुनें। जब आपने टिकट आवंटित कर दिया है, तो उसकी तारीख और समय दर्ज करें और फिर टिकट जमा करें।",
      "en": "On the left side, in Tickets, we can create a new ticket in Add New Ticket, so that we can assign tasks to our employees. In that, in Customer Type, select whether we are assigning Ticket to Customer, Lead or someone else. After that we should select the name of that Customer or Lead in the dropdown given below. In the Ticket Title, we should put whatever instructions we want to give to our employees. In Ticket Priority, we should select the priority of solving this ticket, i.e. High, Medium or Low. Then in the Ticket Description, we should enter whatever Details or Description the Employees have to give to Task Resolve in the Ticket Description. After that, to which employee you want to assign this ticket, select the name of that employee in Ticket Assign. When you have assigned the ticket, enter its date and time and then submit the ticket."
    },
    "cue": [
      {
        "id": "click-0",
        "kind": "click",
        "selector": "input[name=\"cust_type\"][value=\"Customers\"]",
        "at": 0.13
      },
      {
        "id": "select-1",
        "kind": "select",
        "selector": "#ref_id",
        "at": 0.24,
        "label": "Adinath Mhaske"
      },
      {
        "id": "type-2",
        "kind": "type",
        "selector": "#tkt_title",
        "at": 0.34,
        "value": "Visit for service."
      },
      {
        "id": "select-3",
        "kind": "select",
        "selector": "#ticket_priority",
        "at": 0.44,
        "label": "High"
      },
      {
        "id": "type-4",
        "kind": "type",
        "selector": "#ticket_desc",
        "at": 0.57,
        "value": "Provide the GPM service properly."
      },
      {
        "id": "select-5",
        "kind": "select",
        "selector": "#ticket_assign_to",
        "at": 0.74,
        "label": "Prajyot"
      },
      {
        "id": "dateTime-6",
        "kind": "dateTime",
        "selector": "#ticket_date",
        "at": 0.84
      },
      {
        "id": "storySave-7",
        "kind": "storySave",
        "selector": "#add_edit_form_btn",
        "at": 0.95,
        "value": "ticket_prepare"
      }
    ]
  },
  {
    "id": "f17",
    "chapter": {
      "mr": "F17",
      "hi": "F17",
      "en": "F17"
    },
    "url": "assets/demo-mobile/index.html?screen=tickets&connected=1",
    "selector": "#ticket-list",
    "title": {
      "mr": "Resolve Ticket on the mobile application",
      "hi": "Resolve Ticket on the mobile application",
      "en": "Resolve Ticket on the mobile application"
    },
    "text": {
      "mr": "टिकीट असाइन केल्यानंतर Employee आपल्या मोबाईल ॲप्लिकेशनमध्ये My Tickets मध्ये जाऊन त्याला असाइन केलेले Tickets बघू शकतो. त्या पर्टिक्युलर Ticket वरती क्लिक करून तो त्याचे Details बघू शकतो की हे Ticket कोणत्या Customer किंवा Lead बद्दल Create केलेले आहे आणि त्यांचे Location काय आहे. त्यामध्ये Description मध्ये तो बघू शकतो की त्याला Field वरती जाऊन नेमके काय काम करायचे आहे. आणि जेव्हा तो त्या Field वरती जाईल, तेव्हा तो त्या Ticket वरती क्लिक करून Right Side Corner वरती असलेल्या तीन डॉट्सवरती क्लिक करेल. त्यानंतर तिथे Start Ticket हा Option येईल. Start Ticket वरती क्लिक केल्यानंतर त्यांना Start Ticket Remark टाकावा लागेल. त्यामध्ये ते Starting Work असे Remark टाकू शकतात. त्यानंतर Start Ticket या बटनवरती क्लिक करून ते Ticket Start करू शकतात. Ticket Start केल्यानंतर जेव्हा त्यांचे Work पूर्ण होईल, त्यानंतर परत याचप्रमाणे Right Side Corner वरती असलेल्या तीन डॉट्सवरती क्लिक करून तिथे Update Ticket असा Option येईल. त्या Update Ticket Option वरती क्लिक केल्यानंतर त्यामध्ये Review आणि Description असे Fields असतील. Review मध्ये Customer ला कोणती Service Provide केली आहे, ते ते लिहू शकतात. Description मध्ये त्यांनी Customer च्या ठिकाणी काही Extra Material वगैरे वापरले आहे, काही Work Incomplete आहे किंवा परत Field वरती Visit करायची आहे, यासारखी माहिती ते Detail मध्ये लिहू शकतात. त्यानंतर Work Type मध्ये काय काम केले आहे, जसे की Service केली आहे, Repair केली आहे किंवा Both, यापैकी योग्य Option Select करू शकतात. त्यानंतर Status मध्ये Open आणि Resolved असे Options असतील. जर काम पूर्ण झालेले नसेल आणि परत एकदा Visit करायची असेल, तर तिथे Open Select करू शकता. आणि जर काम पूर्ण झालेले असेल, तर Resolved Option Select करू शकता. त्यानंतर Browse वरती क्लिक करून ते कामाशी संबंधित Image Capture किंवा Upload करू शकतात. Image Capture केल्यानंतर Update या बटनवरती क्लिक करायचे. त्यानंतर Client Signature घेऊन ते Ticket Submit करू शकतात.",
      "hi": "Ticket Assign होने के बाद Employee अपने Mobile Application में My Tickets पर जाकर उसे Assign किए गए Tickets देख सकता है। किसी Particular Ticket पर क्लिक करके वह उसकी Details देख सकता है कि Ticket किस Customer या Lead के बारे में बनाया गया है और उनकी Location क्या है। Description में वह देख सकता है कि Field पर जाकर उसे ठीक कौन-सा काम करना है। Field पर पहुँचने के बाद वह Ticket पर क्लिक करके Right Side Corner में दिए गए तीन Dots पर क्लिक करेगा। इसके बाद Start Ticket Option दिखाई देगा। Start Ticket पर क्लिक करने के बाद उसे Start Ticket Remark दर्ज करना होगा। वह Remark में Starting Work लिख सकता है। फिर Start Ticket Button पर क्लिक करके Ticket Start कर सकता है। Work पूरा होने पर दोबारा Right Side Corner के तीन Dots पर क्लिक करने से Update Ticket Option दिखाई देगा। Update Ticket पर क्लिक करने के बाद Review और Description Fields दिखाई देंगे। Review में Employee लिख सकता है कि Customer को कौन-सी Service दी गई है। Description में वह Detail से लिख सकता है कि Customer के यहाँ कोई Extra Material इस्तेमाल किया गया है, कोई Work Incomplete है या Field पर दोबारा Visit करना है। फिर Work Type में Service, Repair या Both में से सही Option Select कर सकता है। Status में Open और Resolved Options होंगे। यदि Work पूरा नहीं हुआ है और दोबारा Visit करना है, तो Open Select करें। यदि Work पूरा हो गया है, तो Resolved Select करें। फिर Browse पर क्लिक करके Work से संबंधित Image Capture या Upload की जा सकती है। Image Capture करने के बाद Update Button पर क्लिक करें। इसके बाद Client Signature लेकर Ticket Submit किया जा सकता है।",
      "en": "After a Ticket is Assigned, the Employee can open My Tickets in the Mobile Application and view the Tickets Assigned to them. By selecting a Particular Ticket, the Employee can see which Customer or Lead the Ticket is about and view their Location. The Description explains exactly what work must be completed at the Field location. After reaching the Field, the Employee opens the Ticket and selects the three Dots in the Right Side Corner. The Start Ticket Option then appears. The Employee enters a Start Ticket Remark, such as Starting Work, and selects the Start Ticket Button. After the Work is complete, the Employee selects the three Dots again and chooses Update Ticket. The Update Ticket screen contains Review and Description Fields. In Review, the Employee can record which Service was provided to the Customer. In Description, the Employee can describe any Extra Material used, any Incomplete Work, or whether another Field Visit is required. In Work Type, the Employee selects Service, Repair, or Both. Status provides Open and Resolved Options. Select Open when the Work is incomplete and another Visit is required. Select Resolved when the Work is complete. The Employee can then select Browse to Capture or Upload a work-related Image. After adding the Image, select Update, collect the Client Signature, and Submit the Ticket."
    },
    "cue": [
      {
        "id": "click-0",
        "kind": "click",
        "selector": "#sample-ticket",
        "at": 0.06
      },
      {
        "id": "focus-1",
        "kind": "focus",
        "selector": "#customer-details",
        "at": 0.16
      },
      {
        "id": "focus-2",
        "kind": "focus",
        "selector": "#ticket-details",
        "at": 0.23
      },
      {
        "id": "click-3",
        "kind": "click",
        "selector": "#ticket-menu",
        "at": 0.3
      },
      {
        "id": "click-4",
        "kind": "click",
        "selector": "#start-ticket-option",
        "at": 0.34
      },
      {
        "id": "type-5",
        "kind": "type",
        "selector": "#start-remark",
        "at": 0.38,
        "value": "Starting Work"
      },
      {
        "id": "click-6",
        "kind": "click",
        "selector": "#start-ticket-submit",
        "at": 0.43
      },
      {
        "id": "click-7",
        "kind": "click",
        "selector": "#ticket-menu",
        "at": 0.49
      },
      {
        "id": "click-8",
        "kind": "click",
        "selector": "#update-ticket-option",
        "at": 0.51
      },
      {
        "id": "type-9",
        "kind": "type",
        "selector": "#ticket-review",
        "at": 0.56,
        "value": "Service done"
      },
      {
        "id": "type-10",
        "kind": "type",
        "selector": "#ticket-description",
        "at": 0.62,
        "value": "General pest management service completed."
      },
      {
        "id": "select-11",
        "kind": "select",
        "selector": "#ticket-work-type",
        "at": 0.72,
        "value": "Service"
      },
      {
        "id": "select-12",
        "kind": "select",
        "selector": "#ticket-status",
        "at": 0.78,
        "value": "Resolved"
      },
      {
        "id": "click-13",
        "kind": "click",
        "selector": "#work-photo",
        "at": 0.86
      },
      {
        "id": "click-14",
        "kind": "click",
        "selector": "#update-submit",
        "at": 0.9
      },
      {
        "id": "click-15",
        "kind": "click",
        "selector": "#add-signature",
        "at": 0.93
      },
      {
        "id": "click-16",
        "kind": "click",
        "selector": "#submit-ticket",
        "at": 0.95
      }
    ],
    "prepare": "ticket_prepare"
  },
  {
    "id": "f18",
    "chapter": {
      "mr": "F18",
      "hi": "F18",
      "en": "F18"
    },
    "url": "vendor/customers/ticket_report",
    "selector": ".portlet.light.bordered",
    "title": {
      "mr": "Ticket details and Ticket Summary Report",
      "hi": "Ticket details and Ticket Summary Report",
      "en": "Ticket details and Ticket Summary Report"
    },
    "text": {
      "mr": "अशा प्रकारे त्यांना असाइन केलेले ते पर्टिक्युलर टास्क त्यांनी रिझॉल्व केल्यानंतर, डेस्कटॉपवरती All Ticket Details मध्ये आपण ते बघू शकतो. आपण जी पर्टिक्युलर Ticket ID असाइन केलेली होती, तिच्यासमोरील Status Open वरून चेंज होऊन Resolved असा दिसेल. त्या Ticket ID वरती क्लिक केल्यानंतर आपल्याला त्या Ticket चे पूर्ण Details दिसतील. त्यामध्ये आपल्या Employee ने Ticket किती वाजता Start केले होते आणि कधी ते Resolve केले आहे, हे आपल्याला कळेल. तसेच त्याने तिथे जे काही Remark लिहिलेले होते, जसे की Review आणि Description, ते देखील आपल्याला दिसेल. Ticket Details आपण View केल्यानंतर, त्या ठिकाणी Employee ने Upload केलेली Image आणि Client ची Signature देखील आपले Admins आणि Super Admins बघू शकतात. आणि आपल्या Employee ने Ticket Solve करण्यासाठी किती Duration घेतला आहे, ते देखील आपल्याला कळेल. टिकिट समरी रिपोर्टमध्ये आपण बघू शकतो की आपण टोटल किती Tickets असाइन केलेले होते, त्यापैकी Open Tickets किती आहेत, Reopened Tickets किती आहेत, Resolved Tickets किती आहेत आणि फायनली Closed Tickets किती आहेत. आपण Employee-wise Data देखील बघू शकतो की आपल्या कोणत्या Employee ने किती Tickets Solve केलेले आहेत. त्यामध्ये आपण Ticket Distribution देखील बघू शकतो. म्हणजेच, एखाद्या Specific Employee ला किती Tickets असाइन केलेले आहेत, त्यापैकी किती Tickets त्यांनी Open केले आहेत, किती Resolved झाले आहेत आणि किती Closed झाले आहेत. अशा प्रकारे आपण प्रत्येक Particular Employee चा Data चेक करू शकतो. त्यांचा Monthly किंवा Particular Week चा Data बघायचा असेल आणि त्यांचा Performance चेक करायचा असेल, तर ते देखील आपण Employee Ticket Summary मध्ये बघू शकतो.",
      "hi": "इस प्रकार जब वे उन्हें सौंपे गए विशेष कार्य को हल कर लेते हैं, तो हम इसे डेस्कटॉप पर सभी टिकट विवरण में देख सकते हैं। आपके द्वारा निर्दिष्ट विशेष टिकट आईडी उसके सामने ओपन से रिज़ॉल्व्ड में बदल जाएगी। उस टिकट आईडी पर क्लिक करने के बाद आपको उस टिकट की पूरी जानकारी दिखाई देगी। उसमें आपको पता चल जाएगा कि आपके कर्मचारी ने किस समय टिकट शुरू किया और उसका समाधान कब हुआ। साथ ही उन्होंने वहां जो भी रिमार्क्स लिखे थे, जैसे रिव्यू और डिस्क्रिप्शन, वो भी हम देखेंगे. टिकट विवरण देखने के बाद, आपके एडमिन और सुपर एडमिन कर्मचारी द्वारा अपलोड की गई छवि और ग्राहक के हस्ताक्षर भी देख सकते हैं। और आपको यह भी पता चल जाएगा कि आपके कर्मचारी ने टिकट को हल करने में कितना समय लिया है। टिकट सारांश रिपोर्ट में हम देख सकते हैं कि आवंटित टिकटों की कुल संख्या, कितने खुले टिकट हैं, कितने दोबारा खोले गए टिकट हैं, कितने समाधानित टिकट हैं और कितने अंतिम रूप से बंद टिकट हैं। हम कर्मचारी-वार डेटा भी देख सकते हैं कि हमारे किसी कर्मचारी ने कितने टिकटों का समाधान किया है। उसमें हम टिकट वितरण भी देख सकते हैं. अर्थात्, किसी विशिष्ट कर्मचारी को कितने टिकट आवंटित किए गए हैं, उनके द्वारा कितने टिकट खोले गए हैं, कितने का समाधान किया गया है और कितने बंद किए गए हैं। इस तरह हम प्रत्येक विशेष कर्मचारी के डेटा की जांच कर सकते हैं। यदि हम उनका मासिक या विशेष सप्ताह का डेटा देखना चाहते हैं और उनके प्रदर्शन की जांच करना चाहते हैं, तो हम इसे कर्मचारी टिकट सारांश में भी देख सकते हैं।",
      "en": "Thus after they solve the particular task assigned to them, we can see it in All Ticket Details on the desktop. The particular Ticket ID you assigned will change from Open to Resolved in front of it. After clicking on that Ticket ID, you will see the complete details of that Ticket. In that, you will know what time your employee started the ticket and when it was resolved. Also, we will see whatever Remarks he wrote there, such as Review and Description. After you view the Ticket Details, your Admins and Super Admins can also view the Image uploaded by the Employee and the Signature of the Client. And you will also know how much duration your employee has taken to solve the ticket. In the ticket summary report we can see the total number of tickets assigned, how many are open tickets, how many are reopened tickets, how many are resolved tickets and how many are finally closed tickets. We can also see employee-wise data that how many tickets have been solved by any of our employees. In that we can also see Ticket Distribution. That is, how many tickets are assigned to a specific employee, how many tickets have been opened by them, how many have been resolved and how many have been closed. In this way we can check the data of each particular employee. If we want to see their Monthly or Particular Week Data and check their Performance, we can also see it in the Employee Ticket Summary."
    },
    "cue": [
      {
        "id": "navigate-0",
        "kind": "navigate",
        "selector": "vendor/dashboard/story_ticket",
        "at": 0.13,
        "target": ".page-content table"
      },
      {
        "id": "focus-1",
        "kind": "focus",
        "selector": "table:has(th:nth-child(7))",
        "at": 0.36
      },
      {
        "id": "navigate-2",
        "kind": "navigate",
        "selector": "vendor/customers/ticket_summary_report",
        "at": 0.56,
        "target": ".ticket-summary-page"
      },
      {
        "id": "focus-3",
        "kind": "focus",
        "selector": "#employee_ticket_summary tr:last-child",
        "at": 0.72
      }
    ]
  },
  {
    "id": "f19",
    "chapter": {
      "mr": "F19",
      "hi": "F19",
      "en": "F19"
    },
    "url": "vendor/reports/add_quotation",
    "selector": "#p_quote_name",
    "title": {
      "mr": "Quotations Add New Quotation",
      "hi": "Quotations Add New Quotation",
      "en": "Quotations Add New Quotation"
    },
    "text": {
      "mr": "एमआय बी-ट्रॅक सीआरएममध्ये आपण कोटेशन देखील तयार करू शकतो. लेफ्ट साईडला Quotations मध्ये जाऊन Add New Quotation सिलेक्ट करा. त्यानंतर तेथे Customer Type मध्ये Customer आणि Leads हे दोन ऑप्शन्स दिसतील. आपल्याला ज्याच्यासाठी कोटेशन बनवायचे आहे, ते ऑप्शन सिलेक्ट करा. आपण येथे Customer ऑप्शन सिलेक्ट करूया. त्यानंतर Lead किंवा Customer चे जे नाव आहे, ते ड्रॉपडाऊनमधून सिलेक्ट करा. कोटेशन बनवण्याची किंवा कोटेशन सेंड करण्याची Priority काय आहे, ते सिलेक्ट करूया. High, Medium, Low असे तीन ऑप्शन्सपैकी आपण एक ऑप्शन सिलेक्ट करू शकतो. त्यानंतर GST Type मध्ये GST Applicable आहे का किंवा Without GST आहे, ते सिलेक्ट करा. कोटेशन क्रिएट करण्याची जी Date आहे, ती आपण तिथे टाकू शकतो. त्यानंतर Address, Contact Number हे सर्व Fields Fill करा. त्यानंतर Subject मध्ये आपण कोटेशन क्रिएट करताना जो काही Subject आहे, तो Subject तिथे ॲड करू शकता. जसे की Quotation for General Pest Management Service. त्यानंतर जे काही Description लिहायचे आहे, ते आपण कोटेशनमध्ये लिहू शकतो. Product Details मध्ये कोटेशन कोणत्या Product किंवा Service साठी आपण बनवत आहोत, ते सिलेक्ट करायचे. मी येथे AMC सिलेक्ट केले आहे. AMC मध्ये कोणती AMC आहे, तर General Pest Management मी सिलेक्ट केलेली आहे. Description मध्ये आपण त्या AMC बद्दलचे Description लिहू शकतो. जसे की, “In this AMC, we are providing six services.” त्यानंतर खाली Terms and Conditions टाकू शकतो, जे आपल्याला कोटेशनमध्ये पाहिजे आहेत. आपण हे Terms and Conditions एकत्रित ॲड करून CRM मध्ये ठेवू शकतो, जेणेकरून प्रत्येक कोटेशनसाठी तेच Terms and Conditions वापरता येतील. किंवा आपण कोटेशन क्रिएट करताना ज्या काही Terms आपल्याला वेगवेगळ्या आणि Required आहेत, त्या आपण तिथे देखील ॲड करू शकतो. त्यानंतर हे कोटेशन आपण Submit करून ठेवूया.",
      "hi": "हम एमआई बी-ट्रैक सीआरएम में भी कोटेशन बना सकते हैं। बाईं ओर कोटेशन पर जाएं और नया कोटेशन जोड़ें चुनें। इसके बाद आपको कस्टमर टाइप में दो विकल्प कस्टमर और लीड्स दिखाई देंगे। वह विकल्प चुनें जिसके लिए आप कोटेशन बनाना चाहते हैं। आइए यहां ग्राहक विकल्प चुनें। फिर ड्रॉपडाउन से लीड या ग्राहक का नाम चुनें। आइए चयन करें कि कोटेशन बनाने या कोटेशन भेजने की प्राथमिकता क्या है। हम हाई, मीडियम, लो तीन विकल्पों में से किसी एक को चुन सकते हैं। फिर जीएसटी प्रकार में जीएसटी लागू या बिना जीएसटी का चयन करें। हम वहां कोटेशन बनाने की तारीख दर्ज कर सकते हैं। फिर सभी फ़ील्ड पता, संपर्क नंबर भरें। उसके बाद Subject में आप Quotation बनाते समय जो भी Subject हो उसे जोड़ सकते हैं। जैसे सामान्य कीट प्रबंधन सेवा के लिए कोटेशन। उसके बाद हम जो भी विवरण उद्धरण में लिखना चाहें लिख सकते हैं। उत्पाद विवरण में उस उत्पाद या सेवा का चयन करें जिसके लिए आप कोटेशन बना रहे हैं। मैंने यहां एएमसी का चयन किया है। एएमसी में कौन सा एएमसी है, मैंने जनरल पेस्ट मैनेजमेंट को चुना है। डिस्क्रिप्शन में हम उस AMC के बारे में डिस्क्रिप्शन लिख सकते हैं. जैसे, \"इस एएमसी में, हम छह सेवाएं प्रदान कर रहे हैं।\" फिर आप नीचे नियम और शर्तें दर्ज कर सकते हैं, जो आप कोटेशन में चाहते हैं। हम इन नियम और शर्तों को एक साथ जोड़कर सीआरएम में रख सकते हैं, ताकि हर कोटेशन के लिए समान नियम और शर्तों का उपयोग किया जा सके। या हम कुछ ऐसे शब्द जोड़ सकते हैं जो उद्धरण बनाते समय भिन्न और आवश्यक हों। उसके बाद इस कोटेशन को सबमिट कर देते हैं.",
      "en": "We can also create quotations in MI B-Track CRM. Go to Quotations on the left side and select Add New Quotation. After that you will see two options Customer and Leads in Customer Type. Select the option for whom you want to create a quotation. Let us select the Customer option here. Then select the name of the Lead or Customer from the dropdown. Let's select what is the Priority of making a quotation or sending a quotation. We can select one of the three options High, Medium, Low. Then select GST Applicable or Without GST in GST Type. We can enter the date of creating the quotation there. Then fill all the fields Address, Contact Number. After that, in Subject, you can add whatever Subject is there while creating the quotation. Such as Quotation for General Pest Management Service. After that, we can write whatever description we want to write in quotation. Select the Product or Service for which you are making the quotation in Product Details. I have selected AMC here. Which AMC is in AMC, I have selected General Pest Management. In description we can write description about that AMC. Like, “In this AMC, we are providing six services.” Then you can enter below the Terms and Conditions, which you want in the quotation. We can add these Terms and Conditions together and keep them in CRM, so that the same Terms and Conditions can be used for every quotation. Or we can add some terms which are different and required while creating the quotation. After that, let's submit this quotation."
    },
    "cue": [
      {
        "id": "click-0",
        "kind": "click",
        "selector": "input[name=\"cust_type\"][value=\"Customers\"]",
        "at": 0.13
      },
      {
        "id": "select-1",
        "kind": "select",
        "selector": "#ref_id",
        "at": 0.21,
        "label": "Adinath Mhaske"
      },
      {
        "id": "select-2",
        "kind": "select",
        "selector": "#p_quote_priorty",
        "at": 0.27,
        "label": "High"
      },
      {
        "id": "select-3",
        "kind": "select",
        "selector": "#gst_applicable",
        "at": 0.34,
        "label": "GST Applicable"
      },
      {
        "id": "focus-4",
        "kind": "focus",
        "selector": "#p_quote_date",
        "at": 0.39
      },
      {
        "id": "type-5",
        "kind": "type",
        "selector": "#p_quote_name",
        "at": 0.42,
        "value": "Adinath Mhaske"
      },
      {
        "id": "type-6",
        "kind": "type",
        "selector": "#p_quote_address",
        "at": 0.46,
        "value": "Swastik niwas, khandagale vasti, Mumbai"
      },
      {
        "id": "type-7",
        "kind": "type",
        "selector": "#p_quote_contact",
        "at": 0.49,
        "value": "4152488895"
      },
      {
        "id": "type-8",
        "kind": "type",
        "selector": "#p_quote_subject",
        "at": 0.57,
        "value": "Quotation for general pest management service"
      },
      {
        "id": "type-9",
        "kind": "type",
        "selector": "#p_quote_desc",
        "at": 0.65,
        "value": "Test description"
      },
      {
        "id": "select-10",
        "kind": "select",
        "selector": "#cust_service_type",
        "at": 0.76,
        "label": "AMC"
      },
      {
        "id": "select-11",
        "kind": "select",
        "selector": "#tbl_service_details select[name=\"service_id[]\"]",
        "at": 0.8,
        "label": "General Pest Management"
      },
      {
        "id": "type-12",
        "kind": "type",
        "selector": "#tbl_service_details input[name=\"desc1[]\"]",
        "at": 0.84,
        "value": "In this AMC, we are providing six services."
      },
      {
        "id": "focus-13",
        "kind": "focus",
        "selector": "#tbl_desc_details",
        "at": 0.91
      }
    ]
  },
  {
    "id": "f20",
    "chapter": {
      "mr": "F20",
      "hi": "F20",
      "en": "F20"
    },
    "url": "vendor/reports/quotation_report",
    "selector": ".portlet.light.bordered",
    "title": {
      "mr": "All Quotations Report and follow-up",
      "hi": "All Quotations Report and follow-up",
      "en": "All Quotations Report and follow-up"
    },
    "text": {
      "mr": "त्यानंतर All Quotations Report मध्ये आपण जेवढे काही Quotations बनवले आहेत, ते आपल्याला दिसतील. ते कोटेशन आपण Edit करू शकतो आणि आपण कोटेशनचा Follow-Up पण घेऊ शकतो. जसे की आपण Customer ला Quotation पाठवली आहे, त्यानंतर Next Call Quotation साठी कधी करायचा आहे, ते देखील आपण ॲड करू शकतो.",
      "hi": "उसके बाद ऑल कोटेशन रिपोर्ट में हम अपने द्वारा बनाए गए सभी कोटेशन देखेंगे। हम उस उद्धरण को संपादित कर सकते हैं और हम उद्धरण का फॉलो-अप भी ले सकते हैं। चूँकि हमने ग्राहक को कोटेशन भेज दिया है, तो हम यह भी जोड़ सकते हैं कि अगला कॉल कोटेशन कब करना है।",
      "en": "After that in All Quotations Report, we will see all the Quotations we have made. We can edit that quotation and we can also take follow-up of the quotation. As we have sent the Quotation to the Customer, then we can also add when to make the Next Call Quotation."
    }
  },
  {
    "id": "f21",
    "chapter": {
      "mr": "F21",
      "hi": "F21",
      "en": "F21"
    },
    "url": "vendor/reports/daily_analysis_report",
    "selector": ".portlet.light.bordered",
    "title": {
      "mr": "Daily Analysis Report",
      "hi": "Daily Analysis Report",
      "en": "Daily Analysis Report"
    },
    "text": {
      "mr": "एमआय बी-ट्रॅक सीआरएममध्ये आपण व्हिज्युअलाइज्ड रिपोर्ट किंवा ॲनालिसिस रिपोर्ट देखील बघू शकतो. त्यासाठी लेफ्ट साईडला Reports वरती क्लिक करून Daily Analysis Report वरती सिलेक्ट करा. Daily Analysis Report मध्ये आपण आपल्या पर्टिक्युलर Employee चा Daily Report बघू शकतो. इथे त्यांनी आज किती Leads Generate केल्या, त्यापैकी किती Leads चे Follow-Ups घेतले आहेत, त्यांचे किती Follow-Ups Pending आहेत, त्यांनी किती Tickets Resolve केल्या आहेत, त्यांनी किती Payment Collect केलं आहे, हे सर्व काही आपण Daily Analysis Report मध्ये बघू शकतो. त्यामध्ये आपण त्या Employee चा पर्टिक्युलर एका Month चा किंवा काही दिवसांचा Report देखील बघू शकतो.",
      "hi": "एमआई बी-ट्रैक सीआरएम में हम विज़ुअलाइज़्ड रिपोर्ट या विश्लेषण रिपोर्ट भी देख सकते हैं। इसके लिए बाईं ओर रिपोर्ट पर क्लिक करें और दैनिक विश्लेषण रिपोर्ट चुनें। दैनिक विश्लेषण रिपोर्ट में हम अपने विशेष कर्मचारी की दैनिक रिपोर्ट देख सकते हैं। यहां, हम देख सकते हैं कि उन्होंने आज कितनी लीड उत्पन्न की हैं, कितनी लीड का उन्होंने अनुसरण किया है, कितने फॉलो-अप उनके पास लंबित हैं, उन्होंने कितने टिकटों का समाधान किया है, उन्होंने कितने भुगतान एकत्र किए हैं, यह सब दैनिक विश्लेषण रिपोर्ट में देखा जा सकता है। उसमें हम उस कर्मचारी की एक महीने या कुछ दिनों की विशेष रिपोर्ट भी देख सकते हैं।",
      "en": "In MI B-Track CRM we can also view visualized reports or analysis reports. For that, click on Reports on the left side and select Daily Analysis Report. In Daily Analysis Report we can see the Daily Report of our Particular Employee. Here, we can see how many leads they have generated today, how many leads they have followed up on, how many follow-ups they have pending, how many tickets they have resolved, how many payments they have collected, all this can be seen in the Daily Analysis Report. In that we can also see the particular report of that employee for a month or a few days."
    },
    "cue": [
      {
        "id": "focus-0",
        "kind": "focus",
        "selector": "#user_id",
        "at": 0.25
      },
      {
        "id": "focus-1",
        "kind": "focus",
        "selector": "#tbl_today_leads_list",
        "at": 0.37
      },
      {
        "id": "focus-2",
        "kind": "focus",
        "selector": "#tbl_today_followup_list",
        "at": 0.44
      },
      {
        "id": "focus-3",
        "kind": "focus",
        "selector": "#tbl_pending_followup_list",
        "at": 0.51
      },
      {
        "id": "focus-4",
        "kind": "focus",
        "selector": "#tbl_all_ticket_list",
        "at": 0.58
      },
      {
        "id": "focus-5",
        "kind": "focus",
        "selector": "#tbl_collection_list",
        "at": 0.65
      },
      {
        "id": "focus-6",
        "kind": "focus",
        "selector": "#from_date",
        "at": 0.85
      }
    ]
  },
  {
    "id": "f22",
    "chapter": {
      "mr": "F22",
      "hi": "F22",
      "en": "F22"
    },
    "url": "vendor/reports/roi_report",
    "selector": ".roi-dashboard",
    "title": {
      "mr": "Market Analysis Report",
      "hi": "Market Analysis Report",
      "en": "Market Analysis Report"
    },
    "text": {
      "mr": "अशाच प्रकारे Market Analysis Report देखील आपण बघू शकतो. Reports मध्ये Market Analysis Report वरती क्लिक करून आपण Market Analysis Report बघू शकतो. यामध्ये आपण बघू शकतो की आपल्याला किती Leads आल्या आहेत आणि त्यापैकी किती Leads आपल्या Customers मध्ये Convert झाल्या आहेत. इथे आपल्याला Conversion Rate देखील दिसतो. त्यानंतर Employee-wise Performance आपण येथे बघू शकतो, ज्यामध्ये पर्टिक्युलर Employee ने किती Leads Convert केल्या आहेत, ते आपल्याला दिसेल. त्यानंतर Lead Activity Log मध्ये आपण बघू शकतो की पर्टिक्युलर Employee कोणत्या Lead चा Follow-Up घेत आहे. आपल्याला येथे Employee ROI आणि Reference ROI देखील बघायला मिळतील. Reference ROI मधून आपल्याला एक आयडिया मिळेल की आपल्याला जास्त Business कोणत्या प्लॅटफॉर्मवरून येत आहे. आणि Employee ROI मध्ये आपल्याला आपल्या Employee चा Performance कसा आहे, हे कळेल. पर्टिक्युलर Employee ने किती Leads Customer मध्ये Convert केलेल्या आहेत, हे देखील आपल्याला बघता येईल.",
      "hi": "इसी प्रकार हम मार्केट एनालिसिस रिपोर्ट भी देख सकते हैं। हम रिपोर्ट्स में मार्केट एनालिसिस रिपोर्ट पर क्लिक करके मार्केट एनालिसिस रिपोर्ट देख सकते हैं। इसमें हम देख सकते हैं कि हमें कितनी लीड मिली हैं और उनमें से कितनी लीड को ग्राहक बनाया गया है। यहां हम रूपांतरण दर भी देखते हैं। उसके बाद हम यहां कर्मचारी-वार प्रदर्शन देख सकते हैं, जिसमें हम देखेंगे कि किसी विशेष कर्मचारी द्वारा कितने लीड परिवर्तित किए गए हैं। उसके बाद, हम लीड एक्टिविटी लॉग में देख सकते हैं कि विशेष कर्मचारी किस लीड का अनुसरण कर रहा है। आपको यहां कर्मचारी ROI और संदर्भ ROI भी दिखाई देंगे। रेफरेंस आरओआई से आपको अंदाजा हो जाएगा कि आपको किस प्लेटफॉर्म से ज्यादा बिजनेस मिल रहा है। और Employee ROI में आपको पता चलेगा कि आपके Employee का Performance कैसा है। आप यह भी देख सकते हैं कि किसी विशेष कर्मचारी द्वारा कितने लीड को ग्राहकों में परिवर्तित किया गया है।",
      "en": "In the same way we can also see the Market Analysis Report. We can see Market Analysis Report by clicking on Market Analysis Report in Reports. In this we can see how many leads we have received and how many of those leads have been converted into customers. Here we also see Conversion Rate. After that we can see the Employee-wise Performance here, in which we will see how many leads have been converted by the particular employee. After that, we can see in the Lead Activity Log which lead the particular employee is following up on. You will also see Employee ROI and Reference ROI here. From Reference ROI you will get an idea from which platform you are getting more business. And in Employee ROI you will know how your Employee's Performance is. You can also see how many leads have been converted into customers by a particular employee."
    },
    "cue": [
      {
        "id": "focus-0",
        "kind": "focus",
        "selector": "#total_leads",
        "at": 0.21
      },
      {
        "id": "focus-1",
        "kind": "focus",
        "selector": "#conversion_rate",
        "at": 0.29
      },
      {
        "id": "focus-2",
        "kind": "focus",
        "selector": "#emp_bars",
        "at": 0.35
      },
      {
        "id": "focus-3",
        "kind": "focus",
        "selector": "#roi_table_body",
        "at": 0.48
      },
      {
        "id": "focus-4",
        "kind": "focus",
        "selector": "#reference_roi_table",
        "at": 0.65
      },
      {
        "id": "focus-5",
        "kind": "focus",
        "selector": "#employee_roi_table",
        "at": 0.79
      }
    ]
  },
  {
    "id": "f23",
    "chapter": {
      "mr": "F23",
      "hi": "F23",
      "en": "F23"
    },
    "url": "vendor/reports/all_reports",
    "selector": ".portlet.light.bordered",
    "title": {
      "mr": "All Reports",
      "hi": "All Reports",
      "en": "All Reports"
    },
    "text": {
      "mr": "Reports मध्येच All Reports मध्ये आपण आपल्या सर्व गोष्टींचा Report बघू शकतो. जसं की Masters मध्ये आपण Reference Report, AMC Report, Notification Report आणि Sale Product Report बघू शकतो. Tickets मध्ये आपण Resolved Ticket Report आणि Closed Ticket Report बघू शकतो. Admins मध्ये आपण आपल्या Employees चे Reports आणि Employee Location Reports बघू शकतो. Leads मध्ये आपण Leads Report आणि Confirmed Leads Report बघू शकतो. Customers मध्ये आपण Customer Report, Pending Customer Report, Payment Report, AMC Customer Report, Employee Availability Report, One-Time Service Report आणि Follow-Up Report बघू शकतो. Quotations मध्ये आपण Quotation Report बघू शकतो. त्यानंतर Sales मध्ये आपण Sales Report आणि GST Report बघू शकतो. Analysis Reports मध्ये आपण Complaint Analysis Report, Lead Analysis Report, Collection Report, Ticket Analysis Report आणि Payment Analysis Report बघू शकतो. Services मध्ये आपण Upcoming Service Report आणि Pending Services Report बघू शकतो. त्यानंतर Analysis Graphs देखील आपण बघू शकतो, ज्यामध्ये आपण Leads, Payments आणि Customers यांचे Analysis देखील बघू शकतो. तसेच आपण Complaints चा Report देखील बघू शकतो.",
      "hi": "रिपोर्ट्स में ही हम सभी रिपोर्ट्स में अपनी सभी चीजों की रिपोर्ट देख सकते हैं। मास्टर्स की तरह हम रेफरेंस रिपोर्ट, एएमसी रिपोर्ट, नोटिफिकेशन रिपोर्ट और सेल प्रोडक्ट रिपोर्ट देख सकते हैं। टिकटों में हम समाधानित टिकट रिपोर्ट और बंद टिकट रिपोर्ट देख सकते हैं। एडमिन में हम अपनी कर्मचारी रिपोर्ट और कर्मचारी स्थान रिपोर्ट देख सकते हैं। लीड्स में हम लीड्स रिपोर्ट और कन्फर्म्ड लीड्स रिपोर्ट देख सकते हैं। ग्राहकों में हम ग्राहक रिपोर्ट, लंबित ग्राहक रिपोर्ट, भुगतान रिपोर्ट, एएमसी ग्राहक रिपोर्ट, कर्मचारी उपलब्धता रिपोर्ट, एकमुश्त सेवा रिपोर्ट और अनुवर्ती रिपोर्ट देख सकते हैं। कोटेशन में हम कोटेशन रिपोर्ट देख सकते हैं। उसके बाद सेल्स में हम सेल्स रिपोर्ट और जीएसटी रिपोर्ट देख सकते हैं। विश्लेषण रिपोर्ट में हम शिकायत विश्लेषण रिपोर्ट, लीड विश्लेषण रिपोर्ट, संग्रह रिपोर्ट, टिकट विश्लेषण रिपोर्ट और भुगतान विश्लेषण रिपोर्ट देख सकते हैं। सेवाओं में हम आगामी सेवा रिपोर्ट और लंबित सेवा रिपोर्ट देख सकते हैं। उसके बाद हम एनालिसिस ग्राफ़ भी देख सकते हैं, जिसमें हम लीड्स, पेमेंट्स और कस्टमर्स का एनालिसिस भी देख सकते हैं। हम शिकायत रिपोर्ट भी देख सकते हैं।",
      "en": "In Reports itself, in All Reports, we can see the report of all our things. Like in Masters we can see Reference Report, AMC Report, Notification Report and Sale Product Report. In Tickets we can see Resolved Ticket Report and Closed Ticket Report. In Admins we can see our Employees Reports and Employee Location Reports. In Leads we can see Leads Report and Confirmed Leads Report. In Customers we can see Customer Report, Pending Customer Report, Payment Report, AMC Customer Report, Employee Availability Report, One-Time Service Report and Follow-Up Report. In Quotations we can see Quotation Report. After that in Sales we can see Sales Report and GST Report. In Analysis Reports we can see Complaint Analysis Report, Lead Analysis Report, Collection Report, Ticket Analysis Report and Payment Analysis Report. In Services we can see Upcoming Service Report and Pending Services Report. After that we can also see Analysis Graphs, in which we can also see Analysis of Leads, Payments and Customers. We can also see the Complaints Report."
    },
    "cue": [
      {
        "id": "expand-0",
        "kind": "expand",
        "selector": "a[href=\"#task-1-2\"]",
        "at": 0.09,
        "target": "#task-1-2"
      },
      {
        "id": "expand-1",
        "kind": "expand",
        "selector": "a[href=\"#task-4-1\"]",
        "at": 0.21,
        "target": "#task-4-1"
      },
      {
        "id": "expand-2",
        "kind": "expand",
        "selector": "a[href=\"#task-2-2\"]",
        "at": 0.27,
        "target": "#task-2-2"
      },
      {
        "id": "expand-3",
        "kind": "expand",
        "selector": "a[href=\"#task-4-2\"]",
        "at": 0.33,
        "target": "#task-4-2"
      },
      {
        "id": "expand-4",
        "kind": "expand",
        "selector": "a[href=\"#task-3-2\"]",
        "at": 0.4,
        "target": "#task-3-2"
      },
      {
        "id": "expand-5",
        "kind": "expand",
        "selector": "a[href=\"#task-8-2\"]",
        "at": 0.57,
        "target": "#task-8-2"
      },
      {
        "id": "expand-6",
        "kind": "expand",
        "selector": "a[href=\"#task-6-9\"]",
        "at": 0.62,
        "target": "#task-6-9"
      },
      {
        "id": "expand-7",
        "kind": "expand",
        "selector": "a[href=\"#task-5-2\"]",
        "at": 0.68,
        "target": "#task-5-2"
      },
      {
        "id": "expand-8",
        "kind": "expand",
        "selector": "a[href=\"#task-2-3\"]",
        "at": 0.8,
        "target": "#task-2-3"
      },
      {
        "id": "expand-9",
        "kind": "expand",
        "selector": "a[href=\"#task-6-2\"]",
        "at": 0.86,
        "target": "#task-6-2"
      },
      {
        "id": "expand-10",
        "kind": "expand",
        "selector": "a[href=\"#task-2-4\"]",
        "at": 0.94,
        "target": "#task-2-4"
      }
    ]
  }
];
  w.MIB_TOUR_CONTENT = {
    full: full,
    short: [
  {
    "id": "f01",
    "chapter": {
      "mr": "F01",
      "hi": "F01",
      "en": "F01"
    },
    "url": "vendor/dashboard",
    "selector": ".page-content",
    "title": {
      "mr": "Dashboard introduction",
      "hi": "Dashboard introduction",
      "en": "Dashboard introduction"
    },
    "text": {
      "mr": "हा आपला MI-Btrack CRM चा डॅशबोर्ड आहे.",
      "hi": "यह आपका MI-Btrack CRM का डैशबोर्ड है।",
      "en": "This is your dashboard of MI-Btrack CRM."
    }
  },
  {
    "id": "f03",
    "chapter": {
      "mr": "F03",
      "hi": "F03",
      "en": "F03"
    },
    "url": "vendor/masters/add_amc",
    "selector": "#amc_name",
    "title": {
      "mr": "Masters Add New AMC",
      "hi": "Masters Add New AMC",
      "en": "Masters Add New AMC"
    },
    "text": {
      "mr": "त्यानंतर आपण Master Section मध्ये जाऊन Add New AMC मध्ये AMC ॲड करून ठेवूयात. AMC मध्ये आपण ज्या काही सर्विसेस कस्टमर्सला देत आहोत, ज्या काही AMC देत आहोत, त्या सर्व AMC त्यामध्ये ॲड करून ठेवणार आहोत.",
      "hi": "उसके बाद हम मास्टर सेक्शन में जाते हैं और Add New AMC में AMC जोड़ते हैं। एएमसी में, हम उन सभी सेवाओं को जोड़ने जा रहे हैं जो हम ग्राहकों को प्रदान कर रहे हैं, सभी एएमसी जो हम प्रदान कर रहे हैं।",
      "en": "After that we go to Master Section and add AMC in Add New AMC. In AMC, we are going to add all the services we are providing to the customers, all the AMCs we are providing."
    },
    "cue": [
      {
        "id": "type-0",
        "kind": "type",
        "selector": "#amc_name",
        "at": 0.27,
        "value": "General Pest Management"
      }
    ]
  },
  {
    "id": "f06",
    "chapter": {
      "mr": "F06",
      "hi": "F06",
      "en": "F06"
    },
    "url": "vendor/dashboard",
    "selector": ".page-content",
    "title": {
      "mr": "Leads introduction and Add New Lead",
      "hi": "Leads introduction and Add New Lead",
      "en": "Leads introduction and Add New Lead"
    },
    "text": {
      "mr": "आपल्याला ज्या कुठल्याही प्लॅटफॉर्ममधून लीड्स येत आहेत, जसे की Just Dial, IndiaMart, Meta Ads, Google किंवा आपण कोणतेही कॅम्पेन रन करत असाल, तर तिथून आलेली लीड डायरेक्टली आपल्या CRM मध्ये येईल. ती लीड आपल्याला आपल्या CRM च्या डॅशबोर्डवरती दिसेल की ती लीड आपल्याला कुठल्या प्लॅटफॉर्मवरून आलेली आहे. किंवा आपल्याला लीड मॅन्युअली ॲड करायची असेल, तर आपण Leads मध्ये जाऊन Add New Lead मध्ये ती लीड ॲड करून घेऊयात.",
      "hi": "जिस भी प्लेटफॉर्म से आपको लीड मिल रही है जैसे जस्ट डायल, इंडियामार्ट, मेटा एड्स, गूगल या आप कोई कैंपेन चला रहे हैं तो वहां से लीड सीधे आपके सीआरएम में आ जाएगी। आप उस लीड को अपने CRM डैशबोर्ड पर देखेंगे कि वह लीड किस प्लेटफ़ॉर्म से आपके पास आई थी। या यदि आप मैन्युअल रूप से लीड जोड़ना चाहते हैं, तो हमें लीड्स पर जाना चाहिए और उस लीड को Add New Lead में जोड़ना चाहिए।",
      "en": "Any platform from which you are getting leads like Just Dial, IndiaMart, Meta Ads, Google or if you are running any campaign, the lead from there will directly come into your CRM. You will see that lead on your CRM dashboard from which platform that lead came to you. Or if you want to add the lead manually, then we should go to Leads and add that lead in Add New Lead."
    },
    "cue": [
      {
        "id": "navigate-0",
        "kind": "navigate",
        "selector": "vendor/leads/add_lead",
        "at": 0.86,
        "target": "#lead_name"
      },
      {
        "id": "type-1",
        "kind": "type",
        "selector": "#lead_name",
        "at": 0.93,
        "value": "Ambar Patil"
      }
    ]
  },
  {
    "id": "f08",
    "chapter": {
      "mr": "F08",
      "hi": "F08",
      "en": "F08"
    },
    "url": "vendor/leads/view_lead?id=NzAwOA%3D%3D",
    "selector": "a[title=\"Add Follow-up\"]",
    "title": {
      "mr": "Lead Followup",
      "hi": "Lead Followup",
      "en": "Lead Followup"
    },
    "text": {
      "mr": "लीड ॲड केल्यानंतर आपण त्या लीडचा फॉलो-अप घेऊ शकतो, जेणेकरून ती लीड आपल्या कस्टमरमध्ये कन्वर्ट होईल. यासाठी आपल्या त्या लीडसोबत जे काही डिस्कशन झालं आहे, ते आपण फॉलो-अपमध्ये ॲड करून घेऊ शकतो. जेणेकरून उद्या जेव्हा आपल्याला त्या लीडबद्दल पुन्हा बोलायचं असेल, तेव्हा मागच्या वेळेस काय बोलणं झालं होतं, हे आपल्याला लक्षात ठेवायची गरज नाही.",
      "hi": "लीड जोड़ने के बाद, हम उस लीड पर फ़ॉलो-अप कर सकते हैं, ताकि लीड हमारे ग्राहक में परिवर्तित हो जाए। इसके लिए, हम उस लीड के साथ जो भी चर्चा करेंगे उसे फॉलो-अप में जोड़ सकते हैं। ताकि कल जब हम उस लीड के बारे में दोबारा बात करना चाहें तो हमें यह याद न रखना पड़े कि पिछली बार क्या कहा गया था।",
      "en": "After adding a lead, we can follow-up on that lead, so that the lead converts into our customer. For this, we can add whatever discussion we have with that lead in the follow-up. So that when we want to talk about that lead again tomorrow, we don't have to remember what was said last time."
    },
    "cue": [
      {
        "id": "click-0",
        "kind": "click",
        "selector": "a[title=\"Add Follow-up\"]",
        "at": 0.05
      },
      {
        "id": "type-1",
        "kind": "type",
        "selector": "#followup_feedback",
        "at": 0.44,
        "value": "Need Followup"
      }
    ]
  },
  {
    "id": "f10",
    "chapter": {
      "mr": "F10",
      "hi": "F10",
      "en": "F10"
    },
    "url": "vendor/customers/add_customer",
    "selector": "#cust_name",
    "title": {
      "mr": "Customers Add New Customer",
      "hi": "Customers Add New Customer",
      "en": "Customers Add New Customer"
    },
    "text": {
      "mr": "त्यानंतर आपण कस्टमर्स ॲड करून ठेवूयात. Customers मध्ये Add New Customer मध्ये जाऊयात. त्यानंतर आपण कस्टमरचे सर्व डिटेल्स यामध्ये एंटर करून ठेवूयात. Service Type मध्ये AMC सिलेक्ट करूयात आणि GST Option मध्ये With GST सिलेक्ट करूयात. त्यानंतर कस्टमरचा GST नंबर असेल, तर तोही आपण टाकू शकतो. त्यानंतर कस्टमरचे नाव आपण टाकून घेऊयात, त्यांचा कॉन्टॅक्ट नंबर आणि ईमेल आयडी असे सर्व डिटेल्स आपण इथे फिल करून घेऊयात. कस्टमरचा ॲड्रेसदेखील आपण यात टाकू शकतो. कस्टमर कधी ॲड झालेला आहे, हे आपण Customer Added Date मध्ये टाकून घेऊयात. त्यानंतर खाली आलेल्या सर्विसेसमधून जी काही AMC आपण त्याला देत आहोत, ती AMC आपण सिलेक्ट करून घेऊयात. AMC ची जी काही रक्कम आहे, ती अमाऊंट इथे येते. जर आपल्याला ती एडिट करायची असेल, तर तेही आपण इथून करू शकतो. आपण कस्टमरला ज्या दिवशी सर्विस देत आहोत, ती दिनांक जर आपल्याला चेंज करायची असेल, तर तेही आपण चेंज करू शकतो. कस्टमरने जर पेमेंट ऑलरेडी केलेलं असेल, तर Paid Amount जी काही असेल, ती आपण Payment Mode मध्ये Cash, Online जे काही असेल ते सिलेक्ट करून तिथे अमाऊंट टाकू शकतो. त्यानंतर या कस्टमरचा आपल्याला Reference By ॲड करायचा असेल, तर तोही आपण इथे ॲड करू शकतो. Alternate Contact Numbers वगैरे आपण ॲड करू शकतो, जेणेकरून कस्टमर जर अवेलेबल नसेल, तर अल्टरनेट कॉन्टॅक्ट नंबरवर कॉल करता येईल. त्यानंतर आपण तो कस्टमर Submit करून देऊयात.",
      "hi": "उसके बाद हम ग्राहक जोड़ेंगे. चलिए Customers में Add New Customer पर चलते हैं. इसके बाद हम ग्राहक की सारी डिटेल इसमें डाल देंगे. सर्विस टाइप में एएमसी चुनें और जीएसटी विकल्प में विद जीएसटी चुनें। इसके बाद अगर ग्राहक के पास जीएसटी नंबर है तो हम उसे भी डाल सकते हैं. इसके बाद हम ग्राहक का नाम लेंगे, उनका कॉन्टैक्ट नंबर और ईमेल आईडी जैसी सारी जानकारी यहां भरेंगे। हम ग्राहक का पता भी दर्ज कर सकते हैं। जब ग्राहक जुड़ जाता है, तो उसे Customer Added Date में डाल देते हैं। उसके बाद, हम निम्नलिखित सेवाओं में से उस एएमसी का चयन करेंगे जो हम उसे दे रहे हैं। जितनी भी एएमसी होती है, वह रकम यहां आती है। अगर हम इसे संपादित करना चाहते हैं, तो हम यहां से ऐसा कर सकते हैं। जिस तारीख को हम ग्राहक को सेवा प्रदान कर रहे हैं यदि हम उसे बदलना चाहें तो वह भी बदल सकते हैं। यदि ग्राहक ने पहले ही भुगतान कर दिया है, तो भुगतान राशि जो भी हो, हम भुगतान मोड में नकद, ऑनलाइन का चयन कर सकते हैं और वहां राशि दर्ज कर सकते हैं। उसके बाद अगर हम इस ग्राहक का Reference By जोड़ना चाहें तो उसे भी यहां जोड़ सकते हैं. हम वैकल्पिक संपर्क नंबर आदि जोड़ सकते हैं, ताकि यदि ग्राहक उपलब्ध नहीं है, तो वैकल्पिक संपर्क नंबर पर कॉल किया जा सके। उसके बाद हम उस ग्राहक को सबमिट कर देंगे.",
      "en": "After that we will add customers. Let's go to Add New Customer in Customers. After that we will enter all the details of the customer in it. Select AMC in Service Type and select With GST in GST Option. After that, if the customer has GST number, we can also enter it. After that we will take the name of the customer, we will fill all the details like their contact number and email id here. We can also enter the address of the customer. When the customer is added, let's put it in Customer Added Date. After that, we will select the AMC that we are giving him from the following services. Any amount of AMC, that amount comes here. If we want to edit it, we can do that from here. If we want to change the date on which we are providing service to the customer, we can change that too. If the customer has already made the payment, then whatever the Paid Amount is, we can select Cash, Online in the Payment Mode and enter the amount there. After that, if we want to add Reference By of this customer, we can also add it here. We can add Alternate Contact Numbers etc., so that if the customer is not available, then the alternate contact number can be called. After that we will submit that customer."
    },
    "cue": [
      {
        "id": "select-0",
        "kind": "select",
        "selector": "#cust_service_type",
        "at": 0.13,
        "label": "AMC",
        "allowDemoValue": true
      },
      {
        "id": "select-1",
        "kind": "select",
        "selector": "#cust_gst_type",
        "at": 0.17,
        "label": "With GST",
        "allowDemoValue": true
      },
      {
        "id": "type-2",
        "kind": "type",
        "selector": "#cust_gstno",
        "at": 0.22,
        "value": "XXXXXXXX1234"
      },
      {
        "id": "type-3",
        "kind": "type",
        "selector": "#cust_name",
        "at": 0.27,
        "value": "Adinath Mhaske"
      },
      {
        "id": "type-4",
        "kind": "type",
        "selector": "#cust_contact",
        "at": 0.3,
        "value": "4152488895"
      },
      {
        "id": "type-5",
        "kind": "type",
        "selector": "#cust_contact_email",
        "at": 0.33,
        "value": "aadinath@gmail.com"
      },
      {
        "id": "type-6",
        "kind": "type",
        "selector": "#cust_address",
        "at": 0.38,
        "value": "Swastik niwas, khandagale vasti, Mumbai."
      },
      {
        "id": "focus-7",
        "kind": "focus",
        "selector": "#cust_ui_date",
        "at": 0.43
      },
      {
        "id": "focus-8",
        "kind": "focus",
        "selector": "#amcSearch",
        "at": 0.49
      },
      {
        "id": "focus-9",
        "kind": "focus",
        "selector": "#cust_total_amount",
        "at": 0.55
      },
      {
        "id": "focus-10",
        "kind": "focus",
        "selector": "#company_pay_type",
        "at": 0.7
      },
      {
        "id": "focus-11",
        "kind": "focus",
        "selector": "#full_payment_section #cust_paid_amount",
        "at": 0.74
      },
      {
        "id": "select-12",
        "kind": "select",
        "selector": "#cust_refbyid",
        "at": 0.82,
        "label": "Google",
        "allowDemoValue": true
      },
      {
        "id": "type-13",
        "kind": "type",
        "selector": "#alt_cust_contact",
        "at": 0.88,
        "value": "2254632584"
      }
    ]
  },
  {
    "id": "f11",
    "chapter": {
      "mr": "F11",
      "hi": "F11",
      "en": "F11"
    },
    "url": "vendor/customers/view_customer?id=NjAxMw%3D%3D",
    "selector": ".followuptbl:has(a[title=\"Click To Schedule\"])",
    "title": {
      "mr": "Customer services and dashboard",
      "hi": "Customer services and dashboard",
      "en": "Customer services and dashboard"
    },
    "text": {
      "mr": "कस्टमर सबमिट झाल्यानंतर ज्या काही AMC सर्विसेस आपण कस्टमरला देत आहोत, त्या आपल्याला खाली दिसतील. ती सर्विस जर कंप्लेंटची असेल, तर आपण तिथे Cancel Service करून Completed Reason टाकून ती सर्विस सबमिट करू शकतो. किंवा जर ही सर्विस आपल्याला शेड्युल करायची असेल आणि कोणाला टास्क असाइन करायचा असेल, तर आपण Schedule मध्ये क्लिक करून, Schedule या बटनावर क्लिक करून ती सर्विस शेड्युल करू शकतो. आपण जर डॅशबोर्डवरती जाऊन चेक केलं, तर आपल्याला Pending Services मध्ये आपण कस्टमर क्रिएट केलेला आहे, त्याची सर्विस दाखवेल की या कस्टमरची सर्विस बाकी आहे. मग आपण त्या कस्टमरवरती क्लिक करून त्याची सर्विस आपण Complete करू शकतो. त्यानंतर आपण या कस्टमरबद्दल जे काही फॉलो-अप असेल, ते फॉलो-अप्सदेखील खाली Add Follow-ups मध्ये जाऊन ॲड करू शकतो. आणि जर पेमेंट नंतर आले असेल, तर Payment या बटनवरती क्लिक करून आपण ते पेमेंट देखील ॲड करू शकतो. ज्या कोणत्या कस्टमरचे पेमेंट पेंडिंग आहे, ते देखील आपल्याला डॅशबोर्डवरती Payment Defaulters असे दिसेल.",
      "hi": "नीचे कुछ एएमसी सेवाएं दी गई हैं जो हम ग्राहक के सबमिशन के बाद ग्राहक को प्रदान कर रहे हैं। यदि वह सेवा शिकायत के लिए है, तो हम वहां सेवा रद्द कर सकते हैं और पूर्ण कारण दर्ज करके उस सेवा को सबमिट कर सकते हैं। या फिर अगर हम इस सर्विस को शेड्यूल करना चाहते हैं और किसी को कोई कार्य सौंपना चाहते हैं तो हम शेड्यूल बटन पर क्लिक करके उस सर्विस को शेड्यूल कर सकते हैं। यदि आप डैशबोर्ड पर जाकर चेक करते हैं कि आपने पेंडिंग सर्विसेज में एक ग्राहक बनाया है तो इसकी सर्विस से पता चल जाएगा कि इस ग्राहक की सर्विस पेंडिंग है। फिर हम उस ग्राहक पर क्लिक करके सेवा पूरी कर सकते हैं। फिर हम नीचे फॉलो-अप जोड़ें पर जाकर इस ग्राहक के बारे में कोई भी फॉलो-अप जोड़ सकते हैं। और अगर पेमेंट बाद में आती है तो हम पेमेंट बटन पर क्लिक करके उस पेमेंट को भी जोड़ सकते हैं। जिन ग्राहकों का भुगतान लंबित है, उन्हें आप डैशबोर्ड पर भुगतान डिफॉल्टर के रूप में भी देखेंगे।",
      "en": "Below are some of the AMC services we are providing to the customer after customer submission. If that service is for complaint, then we can cancel service there and submit that service by entering Completed Reason. Or if we want to schedule this service and assign a task to someone, then we can schedule that service by clicking on the Schedule button. If you go to the dashboard and check, you have created a customer in Pending Services, its service will show that the service of this customer is pending. Then we can complete the service by clicking on that customer. Then we can add any follow-ups about this customer by going below to Add Follow-ups. And if the payment comes later, then we can add that payment too by clicking on the Payment button. Customers whose payment is pending, you will also see as Payment Defaulters on the dashboard."
    },
    "cue": [
      {
        "id": "focus-0",
        "kind": "focus",
        "selector": "button[onclick^=\"openCompleteServiceModal\"]",
        "at": 0.13
      },
      {
        "id": "focus-1",
        "kind": "focus",
        "selector": "a[title=\"Click To Schedule\"]",
        "at": 0.28
      },
      {
        "id": "navigate-2",
        "kind": "navigate",
        "selector": "vendor/dashboard",
        "at": 0.42,
        "target": ".pending-services-reminder"
      },
      {
        "id": "navigate-3",
        "kind": "navigate",
        "selector": "vendor/customers/view_customer?id=NjAxMw%3D%3D",
        "at": 0.64,
        "target": "a[title=\"Add Follow-up\"]"
      },
      {
        "id": "focus-4",
        "kind": "focus",
        "selector": "a[title=\"Make Payment\"]",
        "at": 0.72
      },
      {
        "id": "navigate-5",
        "kind": "navigate",
        "selector": "vendor/dashboard",
        "at": 0.91,
        "target": ".payment-defaulter-reminder"
      }
    ]
  },
  {
    "id": "f14",
    "chapter": {
      "mr": "F14",
      "hi": "F14",
      "en": "F14"
    },
    "url": "vendor/admin/add_employee",
    "selector": "#emp_name",
    "title": {
      "mr": "Employee Add New Employee",
      "hi": "Employee Add New Employee",
      "en": "Employee Add New Employee"
    },
    "text": {
      "mr": "आपले जे काही टेक्निशियन, फिल्ड वर्कर्स वगैरे आहेत, तर त्यांचे लोकेशन विथ टायमिंग ट्रॅक करण्यासाठी आपण Employee Attendance आणि Employee Location Tracking हे फीचर्स CRM मध्ये यूज केलेले आहेत. तर त्यासाठी आपण सगळ्यात पहिले आपले जे काही सर्व Employees आहेत, ते Create करून घ्यायचे आहेत. तर Employee मध्ये Add New Employee या सेक्शनमध्ये जाऊन तेथे आपल्याला आपल्या Employee चे सर्व डिटेल्स टाकायचे आहेत. जसे की Employee चे नाव, Employee चा Contact Number, ते Employee कोणाला Report करतात, त्यांचे Designation काय आहे, जसे की Employee आहे, Sales Person आहे, Technician आहे का किंवा त्याला आपल्याला Admin बनवायचा आहे, ते Designation आपण Choose करायचे. Employee च्या Designation नुसार त्याला Permissions Assign होतात. म्हणजेच त्याला आपण जे काही Permissions देऊ, त्यानुसार त्याचा Dashboard Visible करू शकतो आणि त्यानुसार तो आपले CRM Access करू शकतो. त्यानंतर Employee च्या Department मध्ये त्याचे Department टाकायचे आहे. Location Tracking ला Yes करायचा आहे, जेणेकरून आपल्याला Field वरती गेलेल्या Employee चे Location कळेल. त्यानंतर Employee ची Joining Date आणि Address वगैरे टाकून घ्यायचा आहे. आपण आपल्या Employee चे Bank Details देखील Add करू शकतो किंवा त्याचे इतर Details देखील Add करू शकतो. त्यानंतर आपण आपल्या Employee चे Details Submit या Button वरती क्लिक करून Submit करायचे आहे.",
      "hi": "हम अपने तकनीशियनों और फील्ड वर्कर्स की लोकेशन तथा समय ट्रैक करने के लिए CRM में Employee Attendance और Employee Location Tracking फीचर्स का उपयोग करते हैं। इसके लिए सबसे पहले हमें अपने सभी Employees बनाने हैं। Employee में Add New Employee सेक्शन में जाकर Employee की सभी डिटेल्स दर्ज करनी हैं। इनमें Employee का नाम, Contact Number, वह किसे Report करता है और उसका Designation क्या है, जैसी जानकारी शामिल है। Designation में Employee, Sales Person, Technician या Admin में से उपयुक्त विकल्प चुनना है। Employee के Designation के अनुसार उसे Permissions मिलती हैं। हम उसे जो Permissions देंगे, उसी के अनुसार उसका Dashboard दिखाई देगा और वह CRM Access कर सकेगा। इसके बाद Employee का Department दर्ज करना है। Location Tracking को Yes करना है, ताकि Field पर गए Employee की Location पता चल सके। फिर Employee की Joining Date और Address दर्ज करना है। हम Employee की Bank Details और दूसरी डिटेल्स भी Add कर सकते हैं। अंत में Submit बटन पर क्लिक करके Employee की डिटेल्स Submit करनी हैं।",
      "en": "We use the Employee Attendance and Employee Location Tracking features in the CRM to track the location and timing of our technicians and field workers. For this, we first need to create all our Employees. Go to the Add New Employee section under Employee and enter all the Employee details. These include the Employee name, Contact Number, whom the Employee Reports to, and the Employee's Designation. Choose the appropriate Designation, such as Employee, Sales Person, Technician, or Admin. Permissions are assigned according to the Employee's Designation. The Dashboard will be visible and the Employee will be able to Access the CRM according to the Permissions we provide. Next, enter the Employee's Department. Set Location Tracking to Yes so that we can see the Location of an Employee who has gone into the Field. Then enter the Employee's Joining Date and Address. We can also Add the Employee's Bank Details and other details. Finally, click the Submit button to Submit the Employee details."
    },
    "cue": [
      {
        "id": "type-0",
        "kind": "type",
        "selector": "#emp_name",
        "at": 0.18,
        "value": "Prajyot"
      },
      {
        "id": "type-1",
        "kind": "type",
        "selector": "#emp_mob1",
        "at": 0.24,
        "value": "8546951251"
      },
      {
        "id": "focus-2",
        "kind": "focus",
        "selector": "#emp_rpt_to",
        "at": 0.3
      },
      {
        "id": "select-3",
        "kind": "select",
        "selector": "#permission_id",
        "at": 0.34,
        "label": "Employee",
        "allowDemoValue": true
      },
      {
        "id": "select-4",
        "kind": "select",
        "selector": "#department_id",
        "at": 0.62,
        "label": "Servicing",
        "allowDemoValue": true
      },
      {
        "id": "select-5",
        "kind": "select",
        "selector": "#location_tracking",
        "at": 0.7,
        "value": "Yes"
      },
      {
        "id": "type-6",
        "kind": "type",
        "selector": "#emp_joining_date",
        "at": 0.77,
        "value": "12/12/2012"
      },
      {
        "id": "type-7",
        "kind": "type",
        "selector": "#emp_address",
        "at": 0.81,
        "value": "kiran apartment, Shambhu nagar, Mumbai."
      },
      {
        "id": "focus-8",
        "kind": "focus",
        "selector": "#emp_bank_account_name",
        "at": 0.86
      },
      {
        "id": "focus-9",
        "kind": "focus",
        "selector": "#mybutton",
        "at": 0.94
      }
    ]
  },
  {
    "id": "f16",
    "chapter": {
      "mr": "F16",
      "hi": "F16",
      "en": "F16"
    },
    "url": "vendor/customers/add_ticket",
    "selector": "#tkt_title",
    "title": {
      "mr": "Tickets Add New Ticket",
      "hi": "Tickets Add New Ticket",
      "en": "Tickets Add New Ticket"
    },
    "text": {
      "mr": "लेफ्ट साईडला Tickets मध्ये Add New Ticket मध्ये आपण नवीन Ticket Create करू शकतो, जेणेकरून आपण आपल्या Employees ला Task Assign करू शकतो. त्यामध्ये Customer Type मध्ये आपण Ticket कस्टमर, लीड किंवा दुसऱ्या कोणासाठी Assign करत आहोत, ते Select करायचे. त्यानंतर आपण त्या Customer किंवा Lead चे नाव खाली दिलेल्या Dropdown मध्ये Select करायचे. Ticket Title मध्ये आपण आपल्या Employees ला जे काही Instructions देऊ इच्छितो, त्या Instructions आपण टाकायच्या. Ticket Priority मध्ये हे Ticket Solve करणे किती Priority चे आहे, म्हणजेच High, Medium किंवा Low, ते आपण Select करायचे. त्यानंतर Ticket Description मध्ये Task Resolve करण्यासाठी Employees ला जे काही Details किंवा Description द्यायचे आहे, ते आपण Ticket Description मध्ये टाकायचे. त्यानंतर हे Ticket आपल्याला कोणत्या Employee ला Assign करायचे आहे, ते Ticket Assign मध्ये त्या Employee चे नाव Select करायचे. Ticket आपण कधी Assign केली आहे, त्याची Date आणि Time टाकायची आणि नंतर ते Ticket Submit करायचे.",
      "hi": "बायीं ओर, टिकट्स में, हम ऐड न्यू टिकट में एक नया टिकट बना सकते हैं, ताकि हम अपने कर्मचारियों को कार्य सौंप सकें। उसमें कस्टमर टाइप में सेलेक्ट करें कि हम कस्टमर, लीड या किसी और को टिकट असाइन कर रहे हैं। उसके बाद हमें नीचे दिए गए ड्रॉपडाउन में उस ग्राहक या लीड का नाम चुनना चाहिए। टिकट शीर्षक में हम अपने कर्मचारियों को जो भी निर्देश देना चाहते हैं उसे अवश्य लिखें। टिकट प्राथमिकता में, हमें इस टिकट को हल करने की प्राथमिकता का चयन करना चाहिए, यानी उच्च, मध्यम या निम्न। फिर टिकट विवरण में, कर्मचारियों को टिकट विवरण में कार्य समाधान के लिए जो भी विवरण या विवरण देना है, उसे दर्ज करना चाहिए। इसके बाद आप जिस कर्मचारी को यह टिकट देना चाहते हैं, Ticket Assign में उस कर्मचारी का नाम चुनें। जब आपने टिकट आवंटित कर दिया है, तो उसकी तारीख और समय दर्ज करें और फिर टिकट जमा करें।",
      "en": "On the left side, in Tickets, we can create a new ticket in Add New Ticket, so that we can assign tasks to our employees. In that, in Customer Type, select whether we are assigning Ticket to Customer, Lead or someone else. After that we should select the name of that Customer or Lead in the dropdown given below. In the Ticket Title, we should put whatever instructions we want to give to our employees. In Ticket Priority, we should select the priority of solving this ticket, i.e. High, Medium or Low. Then in the Ticket Description, we should enter whatever Details or Description the Employees have to give to Task Resolve in the Ticket Description. After that, to which employee you want to assign this ticket, select the name of that employee in Ticket Assign. When you have assigned the ticket, enter its date and time and then submit the ticket."
    },
    "cue": [
      {
        "id": "click-0",
        "kind": "click",
        "selector": "input[name=\"cust_type\"][value=\"Customers\"]",
        "at": 0.13
      },
      {
        "id": "select-1",
        "kind": "select",
        "selector": "#ref_id",
        "at": 0.24,
        "label": "Adinath Mhaske",
        "allowDemoValue": true
      },
      {
        "id": "type-2",
        "kind": "type",
        "selector": "#tkt_title",
        "at": 0.34,
        "value": "Visit for service."
      },
      {
        "id": "select-3",
        "kind": "select",
        "selector": "#ticket_priority",
        "at": 0.44,
        "label": "High",
        "allowDemoValue": true
      },
      {
        "id": "type-4",
        "kind": "type",
        "selector": "#ticket_desc",
        "at": 0.57,
        "value": "Provide the GPM service properly."
      },
      {
        "id": "select-5",
        "kind": "select",
        "selector": "#ticket_assign_to",
        "at": 0.74,
        "label": "Prajyot",
        "allowDemoValue": true
      },
      {
        "id": "focus-6",
        "kind": "focus",
        "selector": "#ticket_date",
        "at": 0.84
      },
      {
        "id": "focus-7",
        "kind": "focus",
        "selector": "#add_edit_form_btn",
        "at": 0.95
      }
    ]
  },
  {
    "id": "f17",
    "chapter": {
      "mr": "F17",
      "hi": "F17",
      "en": "F17"
    },
    "url": "vendor/customers/view_ticket?id=OTEwNw%3D%3D",
    "selector": ".page-content",
    "title": {
      "mr": "Resolve Ticket on the mobile application",
      "hi": "Resolve Ticket on the mobile application",
      "en": "Resolve Ticket on the mobile application"
    },
    "text": {
      "mr": "टिकीट असाइन केल्यानंतर Employee आपल्या मोबाईल ॲप्लिकेशनमध्ये My Tickets मध्ये जाऊन त्याला असाइन केलेले Tickets बघू शकतो. त्या पर्टिक्युलर Ticket वरती क्लिक करून तो त्याचे Details बघू शकतो की हे Ticket कोणत्या Customer किंवा Lead बद्दल Create केलेले आहे आणि त्यांचे Location काय आहे. त्यामध्ये Description मध्ये तो बघू शकतो की त्याला Field वरती जाऊन नेमके काय काम करायचे आहे. आणि जेव्हा तो त्या Field वरती जाईल, तेव्हा तो त्या Ticket वरती क्लिक करून Right Side Corner वरती असलेल्या तीन डॉट्सवरती क्लिक करेल. त्यानंतर तिथे Start Ticket हा Option येईल. Start Ticket वरती क्लिक केल्यानंतर त्यांना Start Ticket Remark टाकावा लागेल. त्यामध्ये ते Starting Work असे Remark टाकू शकतात. त्यानंतर Start Ticket या बटनवरती क्लिक करून ते Ticket Start करू शकतात. Ticket Start केल्यानंतर जेव्हा त्यांचे Work पूर्ण होईल, त्यानंतर परत याचप्रमाणे Right Side Corner वरती असलेल्या तीन डॉट्सवरती क्लिक करून तिथे Update Ticket असा Option येईल. त्या Update Ticket Option वरती क्लिक केल्यानंतर त्यामध्ये Review आणि Description असे Fields असतील. Review मध्ये Customer ला कोणती Service Provide केली आहे, ते ते लिहू शकतात. Description मध्ये त्यांनी Customer च्या ठिकाणी काही Extra Material वगैरे वापरले आहे, काही Work Incomplete आहे किंवा परत Field वरती Visit करायची आहे, यासारखी माहिती ते Detail मध्ये लिहू शकतात. त्यानंतर Work Type मध्ये काय काम केले आहे, जसे की Service केली आहे, Repair केली आहे किंवा Both, यापैकी योग्य Option Select करू शकतात. त्यानंतर Status मध्ये Open आणि Resolved असे Options असतील. जर काम पूर्ण झालेले नसेल आणि परत एकदा Visit करायची असेल, तर तिथे Open Select करू शकता. आणि जर काम पूर्ण झालेले असेल, तर Resolved Option Select करू शकता. त्यानंतर Browse वरती क्लिक करून ते कामाशी संबंधित Image Capture किंवा Upload करू शकतात. Image Capture केल्यानंतर Update या बटनवरती क्लिक करायचे. त्यानंतर Client Signature घेऊन ते Ticket Submit करू शकतात.",
      "hi": "Ticket Assign होने के बाद Employee अपने Mobile Application में My Tickets पर जाकर उसे Assign किए गए Tickets देख सकता है। किसी Particular Ticket पर क्लिक करके वह उसकी Details देख सकता है कि Ticket किस Customer या Lead के बारे में बनाया गया है और उनकी Location क्या है। Description में वह देख सकता है कि Field पर जाकर उसे ठीक कौन-सा काम करना है। Field पर पहुँचने के बाद वह Ticket पर क्लिक करके Right Side Corner में दिए गए तीन Dots पर क्लिक करेगा। इसके बाद Start Ticket Option दिखाई देगा। Start Ticket पर क्लिक करने के बाद उसे Start Ticket Remark दर्ज करना होगा। वह Remark में Starting Work लिख सकता है। फिर Start Ticket Button पर क्लिक करके Ticket Start कर सकता है। Work पूरा होने पर दोबारा Right Side Corner के तीन Dots पर क्लिक करने से Update Ticket Option दिखाई देगा। Update Ticket पर क्लिक करने के बाद Review और Description Fields दिखाई देंगे। Review में Employee लिख सकता है कि Customer को कौन-सी Service दी गई है। Description में वह Detail से लिख सकता है कि Customer के यहाँ कोई Extra Material इस्तेमाल किया गया है, कोई Work Incomplete है या Field पर दोबारा Visit करना है। फिर Work Type में Service, Repair या Both में से सही Option Select कर सकता है। Status में Open और Resolved Options होंगे। यदि Work पूरा नहीं हुआ है और दोबारा Visit करना है, तो Open Select करें। यदि Work पूरा हो गया है, तो Resolved Select करें। फिर Browse पर क्लिक करके Work से संबंधित Image Capture या Upload की जा सकती है। Image Capture करने के बाद Update Button पर क्लिक करें। इसके बाद Client Signature लेकर Ticket Submit किया जा सकता है।",
      "en": "After a Ticket is Assigned, the Employee can open My Tickets in the Mobile Application and view the Tickets Assigned to them. By selecting a Particular Ticket, the Employee can see which Customer or Lead the Ticket is about and view their Location. The Description explains exactly what work must be completed at the Field location. After reaching the Field, the Employee opens the Ticket and selects the three Dots in the Right Side Corner. The Start Ticket Option then appears. The Employee enters a Start Ticket Remark, such as Starting Work, and selects the Start Ticket Button. After the Work is complete, the Employee selects the three Dots again and chooses Update Ticket. The Update Ticket screen contains Review and Description Fields. In Review, the Employee can record which Service was provided to the Customer. In Description, the Employee can describe any Extra Material used, any Incomplete Work, or whether another Field Visit is required. In Work Type, the Employee selects Service, Repair, or Both. Status provides Open and Resolved Options. Select Open when the Work is incomplete and another Visit is required. Select Resolved when the Work is complete. The Employee can then select Browse to Capture or Upload a work-related Image. After adding the Image, select Update, collect the Client Signature, and Submit the Ticket."
    },
    "cue": [
      {
        "id": "focus-0",
        "kind": "focus",
        "selector": ".page-content table",
        "at": 0.13
      },
      {
        "id": "focus-1",
        "kind": "focus",
        "selector": "#btn[title=\"Resolve Ticket\"]",
        "at": 0.72
      }
    ]
  },
  {
    "id": "f19",
    "chapter": {
      "mr": "F19",
      "hi": "F19",
      "en": "F19"
    },
    "url": "vendor/reports/add_quotation",
    "selector": "#p_quote_name",
    "title": {
      "mr": "Quotations Add New Quotation",
      "hi": "Quotations Add New Quotation",
      "en": "Quotations Add New Quotation"
    },
    "text": {
      "mr": "एमआय बी-ट्रॅक सीआरएममध्ये आपण कोटेशन देखील तयार करू शकतो. लेफ्ट साईडला Quotations मध्ये जाऊन Add New Quotation सिलेक्ट करा. त्यानंतर तेथे Customer Type मध्ये Customer आणि Leads हे दोन ऑप्शन्स दिसतील. आपल्याला ज्याच्यासाठी कोटेशन बनवायचे आहे, ते ऑप्शन सिलेक्ट करा. आपण येथे Customer ऑप्शन सिलेक्ट करूया. त्यानंतर Lead किंवा Customer चे जे नाव आहे, ते ड्रॉपडाऊनमधून सिलेक्ट करा. कोटेशन बनवण्याची किंवा कोटेशन सेंड करण्याची Priority काय आहे, ते सिलेक्ट करूया. High, Medium, Low असे तीन ऑप्शन्सपैकी आपण एक ऑप्शन सिलेक्ट करू शकतो. त्यानंतर GST Type मध्ये GST Applicable आहे का किंवा Without GST आहे, ते सिलेक्ट करा. कोटेशन क्रिएट करण्याची जी Date आहे, ती आपण तिथे टाकू शकतो. त्यानंतर Address, Contact Number हे सर्व Fields Fill करा. त्यानंतर Subject मध्ये आपण कोटेशन क्रिएट करताना जो काही Subject आहे, तो Subject तिथे ॲड करू शकता. जसे की Quotation for General Pest Management Service. त्यानंतर जे काही Description लिहायचे आहे, ते आपण कोटेशनमध्ये लिहू शकतो. Product Details मध्ये कोटेशन कोणत्या Product किंवा Service साठी आपण बनवत आहोत, ते सिलेक्ट करायचे. मी येथे AMC सिलेक्ट केले आहे. AMC मध्ये कोणती AMC आहे, तर General Pest Management मी सिलेक्ट केलेली आहे. Description मध्ये आपण त्या AMC बद्दलचे Description लिहू शकतो. जसे की, “In this AMC, we are providing six services.” त्यानंतर खाली Terms and Conditions टाकू शकतो, जे आपल्याला कोटेशनमध्ये पाहिजे आहेत. आपण हे Terms and Conditions एकत्रित ॲड करून CRM मध्ये ठेवू शकतो, जेणेकरून प्रत्येक कोटेशनसाठी तेच Terms and Conditions वापरता येतील. किंवा आपण कोटेशन क्रिएट करताना ज्या काही Terms आपल्याला वेगवेगळ्या आणि Required आहेत, त्या आपण तिथे देखील ॲड करू शकतो. त्यानंतर हे कोटेशन आपण Submit करून ठेवूया.",
      "hi": "हम एमआई बी-ट्रैक सीआरएम में भी कोटेशन बना सकते हैं। बाईं ओर कोटेशन पर जाएं और नया कोटेशन जोड़ें चुनें। इसके बाद आपको कस्टमर टाइप में दो विकल्प कस्टमर और लीड्स दिखाई देंगे। वह विकल्प चुनें जिसके लिए आप कोटेशन बनाना चाहते हैं। आइए यहां ग्राहक विकल्प चुनें। फिर ड्रॉपडाउन से लीड या ग्राहक का नाम चुनें। आइए चयन करें कि कोटेशन बनाने या कोटेशन भेजने की प्राथमिकता क्या है। हम हाई, मीडियम, लो तीन विकल्पों में से किसी एक को चुन सकते हैं। फिर जीएसटी प्रकार में जीएसटी लागू या बिना जीएसटी का चयन करें। हम वहां कोटेशन बनाने की तारीख दर्ज कर सकते हैं। फिर सभी फ़ील्ड पता, संपर्क नंबर भरें। उसके बाद Subject में आप Quotation बनाते समय जो भी Subject हो उसे जोड़ सकते हैं। जैसे सामान्य कीट प्रबंधन सेवा के लिए कोटेशन। उसके बाद हम जो भी विवरण उद्धरण में लिखना चाहें लिख सकते हैं। उत्पाद विवरण में उस उत्पाद या सेवा का चयन करें जिसके लिए आप कोटेशन बना रहे हैं। मैंने यहां एएमसी का चयन किया है। एएमसी में कौन सा एएमसी है, मैंने जनरल पेस्ट मैनेजमेंट को चुना है। डिस्क्रिप्शन में हम उस AMC के बारे में डिस्क्रिप्शन लिख सकते हैं. जैसे, \"इस एएमसी में, हम छह सेवाएं प्रदान कर रहे हैं।\" फिर आप नीचे नियम और शर्तें दर्ज कर सकते हैं, जो आप कोटेशन में चाहते हैं। हम इन नियम और शर्तों को एक साथ जोड़कर सीआरएम में रख सकते हैं, ताकि हर कोटेशन के लिए समान नियम और शर्तों का उपयोग किया जा सके। या हम कुछ ऐसे शब्द जोड़ सकते हैं जो उद्धरण बनाते समय भिन्न और आवश्यक हों। उसके बाद इस कोटेशन को सबमिट कर देते हैं.",
      "en": "We can also create quotations in MI B-Track CRM. Go to Quotations on the left side and select Add New Quotation. After that you will see two options Customer and Leads in Customer Type. Select the option for whom you want to create a quotation. Let us select the Customer option here. Then select the name of the Lead or Customer from the dropdown. Let's select what is the Priority of making a quotation or sending a quotation. We can select one of the three options High, Medium, Low. Then select GST Applicable or Without GST in GST Type. We can enter the date of creating the quotation there. Then fill all the fields Address, Contact Number. After that, in Subject, you can add whatever Subject is there while creating the quotation. Such as Quotation for General Pest Management Service. After that, we can write whatever description we want to write in quotation. Select the Product or Service for which you are making the quotation in Product Details. I have selected AMC here. Which AMC is in AMC, I have selected General Pest Management. In description we can write description about that AMC. Like, “In this AMC, we are providing six services.” Then you can enter below the Terms and Conditions, which you want in the quotation. We can add these Terms and Conditions together and keep them in CRM, so that the same Terms and Conditions can be used for every quotation. Or we can add some terms which are different and required while creating the quotation. After that, let's submit this quotation."
    },
    "cue": [
      {
        "id": "click-0",
        "kind": "click",
        "selector": "input[name=\"cust_type\"][value=\"Customers\"]",
        "at": 0.13
      },
      {
        "id": "select-1",
        "kind": "select",
        "selector": "#ref_id",
        "at": 0.21,
        "label": "Adinath Mhaske",
        "allowDemoValue": true
      },
      {
        "id": "select-2",
        "kind": "select",
        "selector": "#p_quote_priorty",
        "at": 0.27,
        "label": "High",
        "allowDemoValue": true
      },
      {
        "id": "select-3",
        "kind": "select",
        "selector": "#gst_applicable",
        "at": 0.34,
        "label": "GST Applicable",
        "allowDemoValue": true
      },
      {
        "id": "focus-4",
        "kind": "focus",
        "selector": "#p_quote_date",
        "at": 0.39
      },
      {
        "id": "type-5",
        "kind": "type",
        "selector": "#p_quote_name",
        "at": 0.42,
        "value": "Adinath Mhaske"
      },
      {
        "id": "type-6",
        "kind": "type",
        "selector": "#p_quote_address",
        "at": 0.46,
        "value": "Swastik niwas, khandagale vasti, Mumbai"
      },
      {
        "id": "type-7",
        "kind": "type",
        "selector": "#p_quote_contact",
        "at": 0.49,
        "value": "4152488895"
      },
      {
        "id": "type-8",
        "kind": "type",
        "selector": "#p_quote_subject",
        "at": 0.57,
        "value": "Quotation for general pest management service"
      },
      {
        "id": "type-9",
        "kind": "type",
        "selector": "#p_quote_desc",
        "at": 0.65,
        "value": "Test description"
      },
      {
        "id": "select-10",
        "kind": "select",
        "selector": "#cust_service_type",
        "at": 0.76,
        "label": "AMC",
        "allowDemoValue": true
      },
      {
        "id": "select-11",
        "kind": "select",
        "selector": "#tbl_service_details select[name=\"service_id[]\"]",
        "at": 0.8,
        "label": "General Pest Management",
        "allowDemoValue": true
      },
      {
        "id": "type-12",
        "kind": "type",
        "selector": "#tbl_service_details input[name=\"desc1[]\"]",
        "at": 0.84,
        "value": "In this AMC, we are providing six services."
      },
      {
        "id": "focus-13",
        "kind": "focus",
        "selector": "#tbl_desc_details",
        "at": 0.91
      }
    ]
  },
  {
    "id": "f21",
    "chapter": {
      "mr": "F21",
      "hi": "F21",
      "en": "F21"
    },
    "url": "vendor/reports/daily_analysis_report",
    "selector": ".portlet.light.bordered",
    "title": {
      "mr": "Daily Analysis Report",
      "hi": "Daily Analysis Report",
      "en": "Daily Analysis Report"
    },
    "text": {
      "mr": "एमआय बी-ट्रॅक सीआरएममध्ये आपण व्हिज्युअलाइज्ड रिपोर्ट किंवा ॲनालिसिस रिपोर्ट देखील बघू शकतो. त्यासाठी लेफ्ट साईडला Reports वरती क्लिक करून Daily Analysis Report वरती सिलेक्ट करा. Daily Analysis Report मध्ये आपण आपल्या पर्टिक्युलर Employee चा Daily Report बघू शकतो. इथे त्यांनी आज किती Leads Generate केल्या, त्यापैकी किती Leads चे Follow-Ups घेतले आहेत, त्यांचे किती Follow-Ups Pending आहेत, त्यांनी किती Tickets Resolve केल्या आहेत, त्यांनी किती Payment Collect केलं आहे, हे सर्व काही आपण Daily Analysis Report मध्ये बघू शकतो. त्यामध्ये आपण त्या Employee चा पर्टिक्युलर एका Month चा किंवा काही दिवसांचा Report देखील बघू शकतो.",
      "hi": "एमआई बी-ट्रैक सीआरएम में हम विज़ुअलाइज़्ड रिपोर्ट या विश्लेषण रिपोर्ट भी देख सकते हैं। इसके लिए बाईं ओर रिपोर्ट पर क्लिक करें और दैनिक विश्लेषण रिपोर्ट चुनें। दैनिक विश्लेषण रिपोर्ट में हम अपने विशेष कर्मचारी की दैनिक रिपोर्ट देख सकते हैं। यहां, हम देख सकते हैं कि उन्होंने आज कितनी लीड उत्पन्न की हैं, कितनी लीड का उन्होंने अनुसरण किया है, कितने फॉलो-अप उनके पास लंबित हैं, उन्होंने कितने टिकटों का समाधान किया है, उन्होंने कितने भुगतान एकत्र किए हैं, यह सब दैनिक विश्लेषण रिपोर्ट में देखा जा सकता है। उसमें हम उस कर्मचारी की एक महीने या कुछ दिनों की विशेष रिपोर्ट भी देख सकते हैं।",
      "en": "In MI B-Track CRM we can also view visualized reports or analysis reports. For that, click on Reports on the left side and select Daily Analysis Report. In Daily Analysis Report we can see the Daily Report of our Particular Employee. Here, we can see how many leads they have generated today, how many leads they have followed up on, how many follow-ups they have pending, how many tickets they have resolved, how many payments they have collected, all this can be seen in the Daily Analysis Report. In that we can also see the particular report of that employee for a month or a few days."
    }
  },
  {
    "id": "f22",
    "chapter": {
      "mr": "F22",
      "hi": "F22",
      "en": "F22"
    },
    "url": "vendor/reports/roi_report",
    "selector": ".roi-dashboard",
    "title": {
      "mr": "Market Analysis Report",
      "hi": "Market Analysis Report",
      "en": "Market Analysis Report"
    },
    "text": {
      "mr": "अशाच प्रकारे Market Analysis Report देखील आपण बघू शकतो. Reports मध्ये Market Analysis Report वरती क्लिक करून आपण Market Analysis Report बघू शकतो. यामध्ये आपण बघू शकतो की आपल्याला किती Leads आल्या आहेत आणि त्यापैकी किती Leads आपल्या Customers मध्ये Convert झाल्या आहेत. इथे आपल्याला Conversion Rate देखील दिसतो. त्यानंतर Employee-wise Performance आपण येथे बघू शकतो, ज्यामध्ये पर्टिक्युलर Employee ने किती Leads Convert केल्या आहेत, ते आपल्याला दिसेल. त्यानंतर Lead Activity Log मध्ये आपण बघू शकतो की पर्टिक्युलर Employee कोणत्या Lead चा Follow-Up घेत आहे. आपल्याला येथे Employee ROI आणि Reference ROI देखील बघायला मिळतील. Reference ROI मधून आपल्याला एक आयडिया मिळेल की आपल्याला जास्त Business कोणत्या प्लॅटफॉर्मवरून येत आहे. आणि Employee ROI मध्ये आपल्याला आपल्या Employee चा Performance कसा आहे, हे कळेल. पर्टिक्युलर Employee ने किती Leads Customer मध्ये Convert केलेल्या आहेत, हे देखील आपल्याला बघता येईल.",
      "hi": "इसी प्रकार हम मार्केट एनालिसिस रिपोर्ट भी देख सकते हैं। हम रिपोर्ट्स में मार्केट एनालिसिस रिपोर्ट पर क्लिक करके मार्केट एनालिसिस रिपोर्ट देख सकते हैं। इसमें हम देख सकते हैं कि हमें कितनी लीड मिली हैं और उनमें से कितनी लीड को ग्राहक बनाया गया है। यहां हम रूपांतरण दर भी देखते हैं। उसके बाद हम यहां कर्मचारी-वार प्रदर्शन देख सकते हैं, जिसमें हम देखेंगे कि किसी विशेष कर्मचारी द्वारा कितने लीड परिवर्तित किए गए हैं। उसके बाद, हम लीड एक्टिविटी लॉग में देख सकते हैं कि विशेष कर्मचारी किस लीड का अनुसरण कर रहा है। आपको यहां कर्मचारी ROI और संदर्भ ROI भी दिखाई देंगे। रेफरेंस आरओआई से आपको अंदाजा हो जाएगा कि आपको किस प्लेटफॉर्म से ज्यादा बिजनेस मिल रहा है। और Employee ROI में आपको पता चलेगा कि आपके Employee का Performance कैसा है। आप यह भी देख सकते हैं कि किसी विशेष कर्मचारी द्वारा कितने लीड को ग्राहकों में परिवर्तित किया गया है।",
      "en": "In the same way we can also see the Market Analysis Report. We can see Market Analysis Report by clicking on Market Analysis Report in Reports. In this we can see how many leads we have received and how many of those leads have been converted into customers. Here we also see Conversion Rate. After that we can see the Employee-wise Performance here, in which we will see how many leads have been converted by the particular employee. After that, we can see in the Lead Activity Log which lead the particular employee is following up on. You will also see Employee ROI and Reference ROI here. From Reference ROI you will get an idea from which platform you are getting more business. And in Employee ROI you will know how your Employee's Performance is. You can also see how many leads have been converted into customers by a particular employee."
    }
  }
]
  };
})(window);
