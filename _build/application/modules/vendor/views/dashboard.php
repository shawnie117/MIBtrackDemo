<?php $role_id = $this->session->userdata('user_role_id'); ?>
<style>
   <style>
   /* ===============================
   HARD RESET – FEEDS LAYOUT
   =============================== */

   .feeds li,
   .feeds .col1,
   .feeds .cont,
   .feeds .cont-col1,
   .feeds .cont-col2,
   .feeds .desc {
      all: unset;
      box-sizing: border-box;
   }


   /* ===============================
   NEW FEEDS LAYOUT (SINGLE SOURCE)
   =============================== */

   .feeds li {
      display: block;
      padding: 8px 10px;
      border-radius: 6px;
   }

   .feeds .col1 {
      width: 100%;
   }

   .feeds .cont {
      display: flex;
      align-items: center;
      gap: 10px;
      width: 100%;
   }

   .feeds .cont-col1 {
      width: 32px;
      flex-shrink: 0;
   }

   .feeds .label {
      width: 28px;
      height: 28px;
      border-radius: 6px;
      display: flex;
      align-items: center;
      justify-content: center;
   }

   .feeds .label i {
      font-size: 16px;
      color: #fff;
   }

   .feeds .cont-col2 {
      flex: 1;
   }

   .feeds .desc {
      display: block;
      line-height: 1.4;
      font-size: 13px;
      color: #333;
   }

   .feeds a {
      display: block;
      text-decoration: none;
   }


   /* =========================================================
   GROUP 1: TOP DASHBOARD 6 BLOCKS
   (New Customer, New Ticket, Follow-Up, etc.)
   ========================================================= */

   .widget-thumb {
      border-radius: 35px;
      background: #ffffff;
      border: 1px solid #a0c3f5;
      /* ensures visibility */
      box-shadow:
         0 4px 10px rgba(0, 0, 0, 0.08),
         0 1px 3px rgba(0, 0, 0, 0.06);
      transition: all 0.25s ease;
   }

   .widget-thumb.bordered {
      border: 1px solid #d1bef996;
      border-radius: 20px;
   }

   .widget-thumb:hover {
      transform: translateY(-6px);
      box-shadow:
         0 10px 22px rgba(0, 0, 0, 0.15),
         0 4px 6px rgba(0, 0, 0, 0.10);
   }

   .widget-thumb-icon {
      width: 56px;
      height: 56px;
      border-radius: 14px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 26px;
      color: #fff;
      box-shadow: inset 0 -3px 0 rgba(0, 0, 0, 0.15);
   }

   .widget-thumb-heading {
      margin-bottom: 12px;
      color: #333;
   }

   .widget-row a {
      text-decoration: none !important;
   }

   /* Icon gradients */
   .bg-green {
      background: linear-gradient(135deg, #43cea2, #185a9d);
   }

   .bg-red {
      background: linear-gradient(135deg, #ff6a6a, #d32f2f);
   }

   .bg-purple {
      background: linear-gradient(135deg, #9d50bb, #6e48aa);
   }

   .bg-blue {
      background: linear-gradient(135deg, #42a5f5, #1565c0);
   }

   .widget-thumb:hover .widget-thumb-icon {
      transform: scale(1.08);
      transition: transform 0.25s ease;
   }


   /* =========================================================
   GROUP 2: TODAY’S TEAM FOLLOW UPS
   ========================================================= */


   .todays-team-followups {
      border-radius: 12px;
      overflow: hidden;
   }

   /* header call icon */
   .todays-team-followups .portlet-title .fa-phone {
      font-size: 20px;
      margin-right: 6px;
      color: #ffffff !important;
   }

   /* Metronic feed layout FIX */
   .todays-team-followups .cont {
      display: table;
      width: 100%;
   }

   .todays-team-followups .cont-col1,
   .todays-team-followups .cont-col2 {
      display: table-cell;
      vertical-align: middle;
   }

   /* icon column */
   .todays-team-followups .cont-col1 {
      width: 42px;
   }

   /* text spacing (NO overlap) */
   .todays-team-followups .cont-col2 {
      padding-left: 8px;
   }

   /* feed rows */
   .todays-team-followups .feeds li {
      border-radius: 6px;
   }

   .todays-team-followups .feeds li:hover {
      background: #f5faff;
   }

   /* icon styling */
   .todays-team-followups .label {
      display: inline-flex;
      align-items: center;
      justify-content: center;
   }

   .todays-team-followups .label i {
      color: #ffffff !important;
      font-size: 16px;
   }

   /* See All Records button */
   .todays-team-followups .team-footer a.team-followup-seeall {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 6px 12px;
      background: #eef7fb;
      color: #E26A6A;
      border-radius: 16px;
      font-size: 13px;
      font-weight: 600;
      text-decoration: none;
   }

   .todays-team-followups .team-footer a.team-followup-seeall:hover {
      background: #d7eff7;
      color: #E26A6A;
   }


   .todays-team-followups .cont-col1 {
      width: 42px;
      float: left;
   }


   .todays-team-followups .desc {
      display: block;
      padding-left: 26px;
      /* 42px icon + gap */
      white-space: normal;
      word-break: break-word;
   }


   .todays-team-followups .cont::after {
      content: "";
      display: table;
      clear: both;
   }

   .todays-team-followups .label i {
      color: #ffffff !important;
      font-size: 24px;
   }

   /* =========================================
   TODAY'S TEAM FOLLOW UPS – LINK & HOVER
   ========================================= */

   /* remove underline from names */
   .todays-team-followups .feeds a {
      text-decoration: none !important;
      color: #428fe7;
   }

   /* row hover animation */
   .todays-team-followups .feeds li {
      transition: background 0.5s ease, transform 0.15s ease;
   }

   /* hover effect */
   .todays-team-followups .feeds li:hover {
      background: #f5faff;
      transform: translateX(2px);
   }

   /* text color on hover */
   .todays-team-followups .feeds li:hover .desc {
      color: #0d47a1;
   }

   .portlet>.portlet-title>.caption>i {
      float: left;
      margin-top: 4px;
      display: inline-block;
      font-size: 17px;
      margin-right: 5px;
      color: #666;
   }


   /* =========================================================
   GROUP 3: TODAY’S MY FOLLOW UPS
   ========================================================= */


   .todays-my-followups {
      border-radius: 12px;
      overflow: hidden;
   }

   /* header icon */
   .todays-my-followups .portlet-title .fa-phone {
      font-size: 18px;
      margin-right: 6px;
   }

   /* feed rows */
   .todays-my-followups .feeds li {
      border-radius: 6px;
   }

   .todays-my-followups .feeds li:hover {
      background: #f5faff;
   }

   /* icon column */
   .todays-my-followups .cont-col1 {
      width: 34px;
   }

   /* 🔥 FIX TEXT OVER ICON */
   .todays-my-followups .cont-col2 {
      margin-left: 10px;
   }

   /* center icon */
   .todays-my-followups .label {
      display: inline-flex;
      align-items: center;
      justify-content: center;
   }

   /* see all */
   .todays-my-followups .my-followup-seeall {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 6px 14px;
      background: #eef7fb;
      color: #0277bd;
      border-radius: 16px;
      font-size: 13px;
      font-weight: 600;
      text-decoration: none;
   }

   .todays-my-followups .my-followup-seeall:hover {
      background: #d7eff7;
      color: #01579b;
   }

   /* ensure icon column stays fixed */

   .todays-my-followups .cont-col1 {
      width: 42px;
      float: left;
   }

   /* ensure text starts AFTER icon */

   .todays-my-followups .desc {
      display: block;
      padding-left: 26px;
      /* 42px icon + gap */
      white-space: normal;
      word-break: break-word;
   }

   /* prevent float collapse */

   .todays-my-followups .cont::after {
      content: "";
      display: table;
      clear: both;
   }

   /* force call icon white + bigger */

   .todays-my-followups .label i {
      color: #ffffff !important;
      font-size: 24px;
   }


   /* remove underline from names */
   .todays-my-followups .feeds a {
      text-decoration: none !important;
      color: #4092f0;
   }

   /* row hover animation */
   .todays-my-followups .feeds li {
      transition: background 0.3s ease, transform 0.15s ease;
   }

   /* hover effect */
   .todays-my-followups .feeds li:hover {
      background: #f5faff;
      transform: translateX(2px);
   }

   /* text color on hover */
   .todays-my-followups .feeds li:hover .desc {
      color: #0d47a1;
   }


   /* =========================================================
   GROUP 4 : LEAD APPROVAL REQUESTS
   ========================================================= */

   .lead-approval-requests {
      border-radius: 12px;
      overflow: hidden;
   }

   /* header icon */
   .lead-approval-requests .portlet-title .fa {
      font-size: 18px;
      margin-right: 6px;
      color: #ffffff !important;
   }

   /* feed rows */
   .lead-approval-requests .feeds li {
      border-radius: 6px;
      transition: background 0.3s ease, transform 0.15s ease;
   }

   .lead-approval-requests .feeds li:hover {
      background: #f5faff;
      transform: translateX(2px);
   }

   /* icon column */
   .lead-approval-requests .cont-col1 {
      width: 42px;
      float: left;
   }

   /* text column */
   .lead-approval-requests .cont-col2 {
      margin-left: 10px;
   }

   /* description text */
   .lead-approval-requests .desc {
      display: block;
      padding-left: 26px;
      white-space: normal;
      word-break: break-word;
      color: #4092f0;
   }

   /* remove underline */
   .lead-approval-requests .feeds a {
      text-decoration: none !important;
   }

   /* hover text color */
   .lead-approval-requests .feeds li:hover .desc {
      color: #0d47a1;
   }

   /* icon alignment */
   .lead-approval-requests .label {
      display: inline-flex;
      align-items: center;
      justify-content: center;
   }

   /* force icon white + size */
   .lead-approval-requests .label i {
      color: #ffffff !important;
      font-size: 24px;
   }

   /* prevent float collapse */
   .lead-approval-requests .cont::after {
      content: "";
      display: table;
      clear: both;
   }

   /* see all records */
   .lead-approval-requests .lead-approval-seeall {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 6px 14px;
      background: #eef7fb;
      color: #0277bd;
      border-radius: 16px;
      font-size: 13px;
      font-weight: 600;
      text-decoration: none;
   }

   .lead-approval-requests .lead-approval-seeall:hover {
      background: #d7eff7;
      color: #01579b;
   }



   .lead-approval-requests .portlet-title {
      background: #E26A6A;
      /* same family as Team Followups */
      color: #ffffff;
      border-bottom: none;
   }

   /* header text */
   .lead-approval-requests .portlet-title .caption {
      color: #333 !important;
   }

   /* header icon */
   .lead-approval-requests .portlet-title .fa {
      color: #ffffff !important;
   }



   .lead-approval-requests {

      border-radius: 12px;
      overflow: hidden;
   }



   /* =========================================================
   PENDING SERVICES REMINDER
   ========================================================= */

   .pending-services-reminder {
      border-radius: 12px;
      overflow: hidden;
      /* border: 1px solid #ef5350; */
   }

   /* header */
   .pending-services-reminder .portlet-title {
      background: #2ab4c0;
      border-bottom: 1px solid #ef5350;
   }

   .pending-services-reminder .portlet-title .caption {
      color: #333;
      font-weight: 600;
   }

   .pending-services-reminder .portlet-title i {
      color: #ffffff;
      font-size: 20px;
      margin-right: 6px;
   }

   /* feed rows */
   .pending-services-reminder .feeds li {
      border-radius: 6px;
      transition: background 0.3s ease, transform 0.15s ease;
   }

   .pending-services-reminder .feeds li:hover {
      background: #fff5f5;
      transform: translateX(2px);
   }

   /* icon column */
   .pending-services-reminder .cont-col1 {
      width: 42px;
      float: left;
   }

   /* text column */
   .pending-services-reminder .cont-col2 {
      padding-left: 10px;
   }

   /* prevent overlap */
   .pending-services-reminder .desc {
      display: block;
      padding-left: 26px;
      white-space: normal;
      word-break: break-word;
   }

   /* clear floats */
   .pending-services-reminder .cont::after {
      content: "";
      display: table;
      clear: both;
   }

   /* icon styling */
   .pending-services-reminder .label {
      display: inline-flex;
      align-items: center;
      justify-content: center;
   }

   .pending-services-reminder .label i {
      color: #ffffff !important;
      font-size: 22px;
   }

   /* remove underline + link color */
   .pending-services-reminder .feeds a {
      text-decoration: none !important;
      color: #337ab7;
   }

   /* hover text color */
   .pending-services-reminder .feeds li:hover .desc {
      color: #2ab4c0;
   }

   /* footer button */
   .pending-services-reminder .pending-seeall {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 6px 14px;
      background: #ffebee;
      color: #E26A6A;
      border-radius: 16px;
      font-size: 13px;
      font-weight: 600;
      text-decoration: none;
   }

   .pending-services-reminder .pending-seeall:hover {

      color: #2ab4c0;
   }

   /* force bullhorn icon white everywhere in Pending Services */
   .pending-services-reminder .fa-bullhorn {
      color: #ffffff !important;
   }

   .pending-services-reminder {
      border: 0.5px solid #2ab4c0 !important;
      /* blue border */
      border-radius: 12px;
   }

   /* =====================================
BIRTHDAY REMINDER PERFECT HEIGHT FIX
===================================== */

   /* same total height as other cards */
   .birthday-reminder .portlet-body {

      position: relative;
   }

   /* proper scrolling */
   .birthday-reminder .slimScrollDiv {

      overflow-y: auto !important;
      overflow-x: hidden !important;
      padding-right: 4px;
   }

   .birthday-reminder .portlet-title {
      height: 46px;
   }

   /* smooth scrollbar */
   .birthday-reminder .slimScrollDiv::-webkit-scrollbar {
      width: 0px;
   }

   .birthday-reminder .slimScrollDiv::-webkit-scrollbar-thumb {
      background: #bdbdbd;
      border-radius: 10px;
   }

   .birthday-reminder .slimScrollDiv::-webkit-scrollbar-track {
      background: transparent;
   }




   /* =========================================
   AMC RENEWAL REMINDER
   ========================================= */

   .amc-renewal-reminder {
      border-radius: 12px;
      overflow: hidden;
      /* border: 2px solid #f44336; */
   }

   /* header icon */
   .amc-renewal-reminder .portlet-title .fa-clock-o {
      font-size: 20px;
      margin-right: 6px;
      color: #ffffff !important;
   }

   /* feed rows */
   .amc-renewal-reminder .feeds li {
      border-radius: 6px;
      transition: background 0.3s ease, transform 0.15s ease;
   }

   .amc-renewal-reminder .feeds li:hover {
      background: #fff5f5;
      transform: translateX(2px);
   }

   /* icon column */
   .amc-renewal-reminder .cont-col1 {
      width: 42px;
      float: left;
   }

   /* text column */
   .amc-renewal-reminder .cont-col2 {
      margin-left: 10px;
   }

   /* text layout */
   .amc-renewal-reminder .desc {
      display: block;
      padding-left: 26px;
      white-space: normal;
      word-break: break-word;
   }

   /* clear floats */
   .amc-renewal-reminder .cont::after {
      content: "";
      display: table;
      clear: both;
   }

   /* icon style */
   .amc-renewal-reminder .label {
      display: inline-flex;
      align-items: center;
      justify-content: center;
   }

   .amc-renewal-reminder .label i {
      color: #ffffff !important;
      font-size: 24px;
   }

   /* remove underline from text */
   .amc-renewal-reminder .feeds a {
      text-decoration: none !important;
      color: #4092f0;
   }

   /* hover text color */
   .amc-renewal-reminder .feeds li:hover .desc {
      color: #b71c1c;
   }

   /* See all button */
   .amc-renewal-reminder .amc-renewal-seeall {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 6px 14px;
      background: #eef7fb;
      color: #0277bd;
      border-radius: 16px;
      font-size: 13px;
      font-weight: 600;
      text-decoration: none;
   }

   .amc-renewal-reminder .amc-renewal-seeall:hover {
      background: #f9d6d5;
      color: #b71c1c;
   }



   /* make list icon background blue */
   .amc-renewal-reminder .label-danger {
      background-color: #2196f3 !important;
   }

   /* make icon inside label white */
   .amc-renewal-reminder .label-danger i {
      color: #ffffff !important;
   }

   /* make text blue */
   .amc-renewal-reminder .feeds a {
      color: #1e88e5 !important;
   }

   /* darker blue on hover */
   .amc-renewal-reminder .feeds li:hover .desc {
      color: #0d47a1 !important;
   }


   /* =========================================
   PAYMENT DEFAULTER CUSTOMERS
   ========================================= */

   .payment-defaulter-reminder {
      /*border: 2px solid #2196f3;*/
      border-radius: 12px;
      overflow: hidden;
   }

   /* header icon */
   .payment-defaulter-reminder .portlet-title i {
      font-size: 20px;
      margin-right: 6px;
      color: #ffffff !important;
   }

   /* feed rows */
   .payment-defaulter-reminder .feeds li {
      border-radius: 6px;
      transition: background 0.3s ease, transform 0.15s ease;
   }

   .payment-defaulter-reminder .feeds li:hover {
      background: #f5faff;
      transform: translateX(2px);
   }

   /* icon column */
   .payment-defaulter-reminder .cont-col1 {
      width: 42px;
      float: left;
   }

   /* text column */
   .payment-defaulter-reminder .cont-col2 {
      margin-left: 10px;
   }

   /* text layout */
   .payment-defaulter-reminder .desc {
      display: block;
      padding-left: 26px;
      white-space: normal;
      word-break: break-word;
   }

   /* clear float */
   .payment-defaulter-reminder .cont::after {
      content: "";
      display: table;
      clear: both;
   }

   /* 🔵 icon background blue */
   .payment-defaulter-reminder .label-danger {
      background: #2196f3 !important;
   }

   /* icon white + big */
   .payment-defaulter-reminder .label i {
      color: #ffffff !important;
      font-size: 24px;
   }

   /* remove underline */
   .payment-defaulter-reminder .feeds a {
      text-decoration: none !important;
      color: #1e88e5;
   }

   /* hover text */
   .payment-defaulter-reminder .feeds li:hover .desc {
      color: #0d47a1;
   }

   /* see all button */
   .payment-defaulter-reminder .payment-defaulter-seeall {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 6px 14px;
      background: #e3f2fd;
      color: #E26A6A;
      border-radius: 16px;
      font-size: 13px;
      font-weight: 600;
      text-decoration: none;
   }

   .payment-defaulter-reminder .payment-defaulter-seeall:hover {
      background: #bbdefb;
      color: #0d47a1;
   }


   /* red background for bell icon box */
   .payment-defaulter-reminder .label-danger {
      background-color: #f44336 !important;
      /* red */
   }

   /* white bell icon */
   .payment-defaulter-reminder .label-danger i.fa-bell {
      color: #ffffff !important;
      font-size: 24px;
   }


   /* =========================================
   RAISED COMPLAINTS REMINDER
   ========================================= */

   .raised-complaints-reminder {
      /* border: 2px solid #f44336; */
      border-radius: 12px;
      overflow: hidden;
   }

   /* header icon */
   .raised-complaints-reminder .portlet-title i {
      font-size: 20px;
      margin-right: 6px;
      color: #ffffff !important;
   }

   /* feed rows */
   .raised-complaints-reminder .feeds li {
      border-radius: 6px;
      transition: background 0.3s ease, transform 0.15s ease;
   }

   .raised-complaints-reminder .feeds li:hover {
      background: #fff5f5;
      transform: translateX(2px);
   }

   /* icon column */
   .raised-complaints-reminder .cont-col1 {
      width: 42px;
      float: left;
   }

   /* text column */
   .raised-complaints-reminder .cont-col2 {
      margin-left: 10px;
   }

   /* text layout */
   .raised-complaints-reminder .desc {
      display: block;
      padding-left: 26px;
      white-space: normal;
      word-break: break-word;
   }

   /* clear floats */
   .raised-complaints-reminder .cont::after {
      content: "";
      display: table;
      clear: both;
   }

   /* red icon box */
   .raised-complaints-reminder .label-danger {
      background: #f44336 !important;
   }

   /* icon white + big */
   .raised-complaints-reminder .label i {
      color: #ffffff !important;
      font-size: 24px;
   }

   /* remove underline */
   .raised-complaints-reminder .feeds a {
      text-decoration: none !important;
      color: #1e88e5;
   }

   /* hover text color */
   .raised-complaints-reminder .feeds li:hover .desc {
      color: #b71c1c;
   }

   /* see all button */
   .raised-complaints-reminder .raised-complaints-seeall {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 6px 14px;
      background: #fdecea;
      color: #3053f0;
      border-radius: 16px;
      font-size: 13px;
      font-weight: 600;
      text-decoration: none;
   }

   .raised-complaints-reminder .raised-complaints-seeall:hover {
      color: #b71c1c;
   }




   /* make icon background blue */
   .raised-complaints-reminder .label-danger {
      background-color: #2196f3 !important;
   }

   /* make icon itself white */
   .raised-complaints-reminder .label-danger i {
      color: #ffffff !important;
      font-size: 24px;
   }


   /*  AUTO-REFLOW REMINDER BLOCKS */
   .reminder-row {
      display: flex;
      flex-wrap: wrap;
   }


   /* 🔥 PERFECT CENTER ALIGNMENT FOR TOP 6 BLOCKS */
   .widget-row-center {
      display: flex;
      justify-content: left;
      flex-wrap: nowrap;
      overflow-x: auto;
   }

   /* remove bootstrap negative margin effect */
   .widget-row-center {
      margin-left: 0;
      margin-right: 0;
   }



   .remainder-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 6px;
      grid-auto-flow: row;
      align-items: start;
   }

   .reminder-item {
      width: 100%;
   }



   /* =========================================================
   UNIVERSAL REMINDER DASHBOARD CSS
   COPY–PASTE ONLY — NO EDITING REQUIRED
   ========================================================= */

   /* ===== GRID LAYOUT ===== */
   .remainder-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 4px;
      align-items: start;
   }

   .reminder-item {
      width: 100%;
   }

   /* ===== BASE PORTLET RESET (kills old colors) ===== */
   .reminder-item .portlet {
      background: #ffffff !important;
      border-radius: 12px;
      overflow: hidden;
      border: 1px solid transparent;
   }


   /* 🔧 METRONIC INLINE HEIGHT OVERRIDE — SHOW 3 FULL ROWS */
   .reminder-item .portlet-body .scroller {
      height: 165px !important;
      min-height: 165px !important;
      max-height: 165px !important;
      overflow-y: auto !important;
   }


   .reminder-item .portlet-title {
      padding: 12px 16px;
      font-weight: 600;
      background: transparent !important;
      border-bottom: none !important;
   }

   .reminder-item .portlet-title .caption {
      color: #ffffff !important;
   }

   .reminder-item .portlet-body {
      padding: 12px;
   }

   /* ===== FEED STRUCTURE ===== */
   .reminder-item .cont {
      display: flex;
      align-items: flex-start;
   }

   .reminder-item .cont-col1 {
      width: 42px;
      flex-shrink: 0;
   }

   .reminder-item .cont-col2 {
      padding-left: 10px;
   }

   .reminder-item .label {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 28px;
      height: 28px;
      border-radius: 6px;
   }

   .reminder-item .label i {
      color: #ffffff !important;
      font-size: 18px;
   }

   /* ===== TEXT ===== */
   .reminder-item .desc {
      display: block;
      white-space: normal;
      word-break: break-word;
   }

   .reminder-item .feeds li {
      border-radius: 6px;
      transition: background 0.3s ease, transform 0.15s ease;
   }

   .reminder-item .feeds li:hover {
      background: #f5faff;
      transform: translateX(2px);
   }

   .reminder-item .feeds a {
      text-decoration: none !important;
   }

   /* ===== FOOTER BUTTON ===== */
   .reminder-item .scroller-footer a {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 6px 14px;
      border-radius: 16px;
      font-size: 13px;
      font-weight: 600;
      text-decoration: none;
   }

   /* =========================================================
   POSITION-BASED COLOR LOGIC (AUTO)
   ========================================================= */

   /* 🔴 RED CELLS: 1,4,5,8,... */
   .remainder-grid>.reminder-item:nth-child(4n+1) .portlet,
   .remainder-grid>.reminder-item:nth-child(4n+4) .portlet {
      border-color: #e57373;
   }

   .remainder-grid>.reminder-item:nth-child(4n+1) .portlet-title,
   .remainder-grid>.reminder-item:nth-child(4n+4) .portlet-title {
      background: #e57373 !important;
   }

   .remainder-grid>.reminder-item:nth-child(4n+1) .label,
   .remainder-grid>.reminder-item:nth-child(4n+4) .label {
      background: #f44336 !important;
   }

   .remainder-grid>.reminder-item:nth-child(4n+1) .feeds a,
   .remainder-grid>.reminder-item:nth-child(4n+4) .feeds a {
      color: #c62828 !important;
   }

   .remainder-grid>.reminder-item:nth-child(4n+1) .scroller-footer a,
   .remainder-grid>.reminder-item:nth-child(4n+4) .scroller-footer a {
      background: #fdecea !important;
      color: #c62828 !important;
   }

   /* 🔵 BLUE CELLS: 2,3,6,7,... */
   .remainder-grid>.reminder-item:nth-child(4n+2) .portlet,
   .remainder-grid>.reminder-item:nth-child(4n+3) .portlet {
      border-color: #4fc3f7;
   }

   .remainder-grid>.reminder-item:nth-child(4n+2) .portlet-title,
   .remainder-grid>.reminder-item:nth-child(4n+3) .portlet-title {
      background: #4fc3f7 !important;
   }

   .remainder-grid>.reminder-item:nth-child(4n+2) .label,
   .remainder-grid>.reminder-item:nth-child(4n+3) .label {
      background: #2196f3 !important;
   }

   .remainder-grid>.reminder-item:nth-child(4n+2) .feeds a,
   .remainder-grid>.reminder-item:nth-child(4n+3) .feeds a {
      color: #0d47a1 !important;
   }

   .remainder-grid>.reminder-item:nth-child(4n+2) .scroller-footer a,
   .remainder-grid>.reminder-item:nth-child(4n+3) .scroller-footer a {
      background: #e3f2fd !important;
      color: #0d47a1 !important;
   }





   /* =========================================================
   FINAL FIX — ICON & TEXT ALIGNMENT
   (Overrides all old Metronic float/table rules)
   ========================================================= */

   /* force clean flex layout */
   .reminder-item .cont {
      display: flex !important;
      align-items: center;
   }

   /* STOP float */
   .reminder-item .cont-col1 {
      float: none !important;
      width: 40px;
      margin-right: 10px;
   }

   /* text column */
   .reminder-item .cont-col2 {
      padding-left: 0 !important;
      margin-left: 0 !important;
      flex: 1;
   }

   /* text block */
   .reminder-item .desc {
      padding-left: 0 !important;
      margin: 0 !important;
      display: block;
      line-height: 1.4;
      color: inherit;
   }

   /* list spacing */
   .reminder-item .feeds li {
      padding: 0px 8px;
   }

   /* icon box consistency */
   .reminder-item .label {
      width: 28px;
      height: 28px;
      border-radius: 6px;
      flex-shrink: 0;
   }

   /* icon size */
   .reminder-item .label i {
      font-size: 16px !important;
   }

   /* =========================================================
   🔥 FINAL HARD FIX — TEXT NOT SHOWING ISSUE
   (Metronic feeds override)
   ========================================================= */

   /* force li to grow with content */
   .remainder-grid .feeds li {
      overflow: visible !important;
   }

   /* kill float layout */
   .remainder-grid .col1 {
      float: none !important;
      width: 100%;
   }

   /* force flex row */
   .remainder-grid .cont {
      display: flex !important;
      align-items: center;
      width: 100%;
      min-height: 26px;
   }

   /* icon column */
   .remainder-grid .cont-col1 {
      float: none !important;
      width: 36px;
      margin-right: 10px;
      flex-shrink: 0;
   }

   /* text column */
   .remainder-grid .cont-col2 {
      flex: 1;
      margin: 0 !important;
      padding: 0 !important;
   }

   /* text itself */
   .remainder-grid .desc {
      display: block !important;
      padding: 0 !important;
      margin: 0 !important;
      line-height: 1.4;
      white-space: normal;
      color: inherit;
   }

   /* make sure anchor does not collapse */
   .remainder-grid .feeds a {
      display: block;
   }

   /* ================================
   FINAL TEXT POSITION FIX
   ================================ */

   /* Ensure icon + text spacing */
   .remainder-grid .cont {
      display: flex !important;
      align-items: center;
   }

   /* Icon column fixed width */
   .remainder-grid .cont-col1 {
      width: 42px !important;
      margin-right: 12px !important;
      /* 🔑 THIS creates space */
      flex-shrink: 0;
   }

   /* Text column */
   .remainder-grid .cont-col2 {
      flex: 1 !important;
      padding-left: 0 !important;
      margin-left: 0 !important;
   }

   /* Actual text */
   .remainder-grid .desc {
      display: block !important;
      padding-left: 0 !important;
      margin-left: 0 !important;
      line-height: 1.5;
      white-space: normal;
   }


   /* Increase reminder text size */
   .remainder-grid .desc {
      font-size: 14.5px !important;
      font-weight: 500;
      line-height: 1.45;
   }

   /* Reduce gap between icon and text */
   .remainder-grid .cont-col1 {
      width: 38px !important;
      margin-right: 8px !important;
   }


   /* 🔧 MOVE TEXT CLOSER TO ICON */

   /* reduce icon column width */
   .remainder-grid .cont-col1 {
      width: 30px !important;
      /* was ~38–42 */
      margin-right: 4px !important;
   }

   /* ensure text starts immediately after icon */
   .remainder-grid .cont-col2 {
      padding-left: 0 !important;
      margin-left: 0 !important;
   }

   /* no extra padding on text */
   .remainder-grid .desc {
      padding-left: 0 !important;
      margin-left: 0 !important;
   }


   /* ===============================
   SEE ALL RECORDS – HOVER EFFECT
   =============================== */

   .remainder-grid .scroller-footer a {
      transition:
         background 0.25s ease,
         color 0.25s ease,
         transform 0.15s ease,
         box-shadow 0.15s ease;
   }

   /* 🔴 RED BLOCK HOVER */
   .remainder-grid>.reminder-item:nth-child(4n+1) .scroller-footer a:hover,
   .remainder-grid>.reminder-item:nth-child(4n+4) .scroller-footer a:hover {
      background: #f44336 !important;
      color: #ffffff !important;
      transform: translateX(3px);
      box-shadow: 0 4px 10px rgba(244, 67, 54, 0.35);
   }

   /* 🔵 BLUE BLOCK HOVER */
   .remainder-grid>.reminder-item:nth-child(4n+2) .scroller-footer a:hover,
   .remainder-grid>.reminder-item:nth-child(4n+3) .scroller-footer a:hover {
      background: #2196f3 !important;
      color: #ffffff !important;
      transform: translateX(3px);
      box-shadow: 0 4px 10px rgba(33, 150, 243, 0.35);
   }

   /* arrow icon animation */
   .remainder-grid .scroller-footer a i {
      transition: transform 0.2s ease;
   }

   .remainder-grid .scroller-footer a:hover i {
      transform: translateX(4px);
   }


   /* ===============================
   WHATSAPP CREDIT – WP BADGE
   =============================== */
   /* =========================================
   STACK WP BELOW QUICK-NAV (SAFE FIX)
   ========================================= */

   /* quick-nav is already fixed — we align to it */
   .wp-credit-wrapper {
      position: fixed;
      right: 10px;
      /* SAME line as quick-nav */
      /* top: 85px; */
      bottom: 200px;
      /* BELOW the 3-line button */
      z-index: 10000;

      /* display: flex;

      align-items: center; */
   }

   /* WP circle same size as quick-nav */
   .wp-credit-circle {
      width: 36px;
      height: 36px;
      background: #25d366;
      color: #ffffff;
      font-size: 14px;
      font-weight: 700;
      border-radius: 50%;

      display: flex;
      align-items: center;
      justify-content: center;

      cursor: pointer;
      box-shadow: 0 6px 14px rgba(0, 0, 0, 0.25);
   }

   /* hover text */
   /* tooltip to LEFT of WP circle */
   .wp-credit-tooltip {
      position: absolute;

      right: 50px;

      top: 50%;
      transform: translateY(-50%);

      background: #25d366;
      color: #fff;

      font-size: 12px;
      font-weight: 600;

      padding: 6px 12px;
      border-radius: 14px;

      white-space: nowrap;

      visibility: hidden;
      opacity: 0;

      transition: all .25s ease;
   }

   .wp-credit-wrapper:hover .wp-credit-tooltip {
      opacity: 1;
      visibility: visible;
      right: 46px;
   }
</style>

</style>
<!-- Content Wrapper. Contains page content -->
<div class="page-content-wrapper">
   <div class="page-content">
      <section class="demo-tour-launcher" aria-label="Guided product tours">
         <div>
            <span class="demo-tour-kicker"><i class="fa fa-play-circle"></i> INTERACTIVE DEMO</span>
            <h3>MI-BTrack guided demonstration</h3>
            <p>Watch the real screens, forms and reports complete the complete business workflow with Marathi guidance. Pause or take control at any time.</p>
         </div>
         <div class="demo-tour-options">
            <a href="<?php echo get_module_path(); ?>dashboard/tour?tour=full"><strong>Full Demo</strong><small>Complete workflow · 23 guided sections</small></a>
            <a class="is-coming-soon" href="<?php echo get_module_path(); ?>dashboard/tour?tour=short" aria-label="Short Demo, coming soon"><strong>Short Demo</strong><small>Focused overview · coming soon</small></a>
         </div>
      </section>
      <style>
         .demo-tour-launcher{margin:0 0 18px;padding:20px 22px;border-radius:12px;background:linear-gradient(120deg,#13233a,#214d7b);color:#fff;display:flex;align-items:center;justify-content:space-between;gap:22px;box-shadow:0 8px 24px rgba(20,47,79,.2)}
         .demo-tour-launcher h3{margin:5px 0;font-size:21px}.demo-tour-launcher p{margin:0;color:#cfe0f2}.demo-tour-kicker{font-size:11px;letter-spacing:1.5px;color:#54dce8}.demo-tour-options{display:flex;gap:9px;flex-wrap:wrap;justify-content:flex-end}.demo-tour-options a{min-width:180px;padding:11px 13px;border:1px solid rgba(255,255,255,.28);border-radius:8px;background:rgba(255,255,255,.1);color:#fff;text-decoration:none;transition:.2s}.demo-tour-options a:hover{background:#2878f0;transform:translateY(-2px)}.demo-tour-options a.is-coming-soon{opacity:.72}.demo-tour-options strong,.demo-tour-options small{display:block}.demo-tour-options small{margin-top:3px;color:#cae0f6;font-size:10px}@media(max-width:900px){.demo-tour-launcher{align-items:flex-start;flex-direction:column}.demo-tour-options{justify-content:flex-start}}
      </style>
      <div style="display: flex; justify-content: space-between; align-items: center;">
         <?php if (!empty($notification_list)) { ?>
            <marquee direction="left">
               <?php foreach ($notification_list as $noti) { ?>
                  <a
                     href="<?php echo get_module_path() . "masters/view_notification/?noti_id=" . base64_encode($noti['noti_id']); ?>">
                     <span class="caption-subject font-red-mint sbold">&nbsp;&nbsp;<?php echo $noti['noti_title']; ?>
                        &nbsp;&nbsp;&nbsp;</span>
                  </a>
               <?php } ?>
            </marquee>
         <?php } ?>

         <?php foreach ($whatsappdeatils as $noti) { ?>

            <div class="wp-credit-wrapper">
               <div class="wp-credit-tooltip">
                  WhatsApp Count is <?php echo $noti['user_wp_credit_count']; ?>
               </div>
               <div class="wp-credit-circle">WP</div>
            </div>


         <?php } ?>


      </div>





      <?php if (!empty($show_subscription_popup) && $show_subscription_popup == true) { ?>

         <style>
            #subscriptionPopup .modal-dialog {
               margin-top: 120px;
            }

            #subscriptionPopup .modal-content {
               border-radius: 16px;
               overflow: hidden;
               box-shadow: 0 15px 40px rgba(0, 0, 0, 0.25);
               border: none;
            }

            #subscriptionPopup .modal-header {
               background: linear-gradient(135deg, #ff6a6a, #ff4d4d);
               color: #fff;
               padding: 18px 25px;
               border-bottom: none;
            }

            #subscriptionPopup .modal-title {
               font-size: 18px;
               font-weight: 600;
               letter-spacing: 0.5px;
               text-align: center;
               width: 100%;
            }


            #subscriptionPopup .modal-body {
               padding: 35px 30px;
               background: #fff;
            }

            #subscriptionPopup .modal-body h4 {
               font-size: 17px;
               font-weight: 500;
               color: #444;
               margin-bottom: 25px;
            }

            #subscriptionPopup .btn-subscription {
               background: linear-gradient(135deg, #ff4d4d, #ff6a6a);
               border: none;
               padding: 10px 28px;
               border-radius: 25px;
               font-weight: 600;
               color: #fff;
               transition: 0.3s ease;
            }

            #subscriptionPopup .btn-subscription:hover {
               transform: translateY(-2px);
               box-shadow: 0 8px 18px rgba(255, 77, 77, 0.4);
            }

            #subscriptionPopup .close {
               color: #fff;
               font-size: 22px;
               opacity: 0.9;
            }

            #subscriptionPopup .close:hover {
               opacity: 1;
            }
         </style>

         <div class="modal fade in" id="subscriptionPopup"
            style="display:block; background:rgba(0,0,0,0.55); backdrop-filter: blur(3px);"
            data-backdrop="static"
            data-keyboard="false">

            <div class="modal-dialog modal-md">
               <div class="modal-content">

                  <div class="modal-header">
                     <button type="button" class="close"
                        onclick="document.getElementById('subscriptionPopup').style.display='none';">
                        &times;
                     </button>

                     <h4 class="modal-title">
                        ⚠ Subscription Expiry Alert
                     </h4>
                  </div>

                  <div class="modal-body text-center">
                     <h4>
                        <?php echo $popup_message; ?>
                     </h4>

                     <a href="<?php echo get_module_path() . 'admin/my_account'; ?>"
                        class="btn btn-subscription">
                        GO TO MY ACCOUNT
                     </a>
                  </div>

               </div>
            </div>
         </div>

      <?php } ?>




      <!-- BEGIN PAGE BASE CONTENT -->
      <div class="row widget-row widget-row-center">

         <?php
         $block_list = !empty($header_menu_list[0]) ? $header_menu_list[0]['dashboardBlockList'] : "";
         if (!empty($block_list)) {
            foreach ($block_list as $key => $block) {
               $d_name = $block['d_name'];
               $icon_color = array("bg-green", "bg-red", "bg-purple", "bg-blue", "bg-green", "bg-red", "bg-purple", "bg-blue");
               $url = "#";
               $icon = "icon-user";
               if ($d_name == "NewCustomer") {
                  $icon = "icon-user";
                  $url = "customers/add_customer";
               }
               if ($d_name == "NewTicket") {
                  $icon = "icon-notebook";
                  $url = "customers/add_ticket";
               }
               if ($d_name == "Follow-Up") {
                  $icon = "icon-call-end";
                  $url = "customers/followup_report";
               }
               if ($d_name == "ComingServices") {
                  $icon = "icon-bell";
                  $url = "customers/upcoming_service_report";
               }
               if ($d_name == "NewComplaint") {
                  $icon = "icon-question";
                  $url = "customers/add_complaint";
               }
               if ($d_name == "MonthScheduler") {
                  $icon = "icon-calendar";
                  $url = "customers/month_scheduler";
               }

               $d_name = preg_replace('/(?<!\ )[A-Z]/', ' $0', $d_name);

         ?>


               <div class="col-md-2" style="padding-left:5px;padding-right:5px; ">
                  <!-- BEGIN WIDGET THUMB -->
                  <a href="<?php echo get_module_path() . $url; ?>" style="text-decoration:none;">
                     <div class="widget-thumb widget-bg-color-white margin-bottom-20 bordered">
                        <center>
                           <h5 class="widget-thumb-heading"
                              style="font-size: 15px;font-weight:800; overflow: hidden; white-space: nowrap; text-overflow:ellipsis">
                              <b><?php echo $d_name; ?></b>
                           </h5>
                           <div class="widget-thumb-wrap" style="display:flex; justify-content:center;">
                              <i class="widget-thumb-icon <?php echo $icon_color[$key]; ?> <?php echo $icon; ?>"></i>
                           </div>

                        </center>
                     </div>
                  </a>
                  <!-- END WIDGET THUMB -->
               </div>
         <?php }
         }
         ?>


      </div>



      <div class="row hidden">
         <?php if (!empty($branch_list)) { ?>
            <form action="<?php echo get_module_path() . 'dashboard/set_branch_dashboard'; ?>" id="confirm_branch_form"
               method="post" autocomplete="off">
               <div class="form-body">
                  <div class="form-group col-md-4">
                     <select class="form-control" id="p_branch" name="p_branch" onchange="this.form.submit();">
                        <option value=""> Select Branch </option>
                        <?php foreach ($branch_list as $branch) {
                           $branch_name = !empty($branch['branch_name']) ? $branch['branch_name'] : $branch['branch_id'];
                           $branch_id = $this->session->userdata('user_branch_id');
                           $selected = ($branch['branch_id'] == $branch_id) ? "selected" : "";
                        ?>
                           <option value="<?php echo $branch['branch_id']; ?>" <?php echo $selected; ?>>
                              <?php echo $branch_name; ?>
                           </option>
                        <?php } ?>
                        <?php echo form_error('p_branch', '<span class="text-danger">', '</span>'); ?>
                     </select>
                  </div>
               </div>
            </form>
         <?php } ?>
      </div>
      <div class="remainder-grid">

         <?php
         $reminder_list = $header_menu_list[0]['reminderBlockList'];
         //echo "<pre/>";print_r($reminder_list);die;
         if (!empty($reminder_list)) {
            foreach ($reminder_list as $key => $reminder) {

               $reminder_name = $reminder['d_name'];
               $d_name = preg_replace('/(?<!\ )[A-Z]/', ' $0', $reminder_name);

               $icon = "icon-bell";
               /*   if($reminder_name == "LeadApprovalRequests"){$icon = "icon-check";}
                 if($reminder_name == "TodaysFollowUps"){  $icon = "icon-call-in"; }
                 if($reminder_name == "TodaysMyFollowUps"){ $icon = "icon-call-out"; }
                 if($reminder_name == "PaymentDefaulterCustomers"){$icon = "icon-bell"; }
                 if($reminder_name == "RaisedComplaints"){$icon = "icon-bubbles";} 
                  */
               if ($reminder_name == "LeadApprovalRequests") {
                  $icon = "fa fa-check";
               }
               if ($reminder_name == "TodaysTeamFollowUps") {
                  $icon = "fa fa-phone";
               }
               if ($reminder_name == "TodaysMyFollowUps") {
                  $icon = "fa fa-phone";
               }
               if ($reminder_name == "PaymentDefaulterCustomers") {
                  $icon = "fa fa-bell";
               }
               if ($reminder_name == "RaisedComplaints") {
                  $icon = "fa fa-bullhorn";
               }
               if ($reminder_name == "Pending Customers") {
                  $icon = "fa fa-bell";
               }
               if ($reminder_name == "AmcRenewal") {
                  $icon = "fa fa-clock-o";
               }
               if ($reminder_name == "PendingServices") {
                  $icon = "fa fa-bullhorn";
               }

               $icon_color = array("red-sunglo", "green-sharp", "red-sunglo", "green-sharp", "red-sunglo", "green-sharp", "red-sunglo", "green-sharp", "red-sunglo");



         ?>
               <!-- BEGIN LEAD APPROVAL REQUEST -->
               <?php if ($reminder_name == "LeadApprovalRequests" && !empty($lead_approval_list['jsArray'])) { ?>
                  <div class="reminder-item">


                     <!-- BEGIN PORTLET -->
                     <div class="portlet box lead-approval-requests">

                        <!-- HEADER -->
                        <div class="portlet-title" style="border-bottom:1px solid #eee;">
                           <div class="caption" style="font-weight:600;color:#333;">
                              <i class="<?php echo $icon; ?>"></i>
                              <?php echo $d_name; ?>

                              <span style="
                              float:right;
                              margin-left:12px;
                              background:#e3f2fd;
                              color:#1565c0;
                              padding:4px 12px;
                              border-radius:14px;
                              font-size:13px;
                              font-weight:600;
                              line-height:1;">
                                 <?php echo $lead_approval_list['total_count']; ?>
                              </span>
                           </div>
                        </div>

                        <!-- BODY -->
                        <div class="portlet-body">
                           <div class="tab-content">
                              <div class="tab-pane active">
                                 <div class="slimScrollDiv">
                                    <ul class="feeds">

                                       <?php foreach ($lead_approval_list['jsArray'] as $lead) {

                                          $name = $lead['clm_name'];
                                          $added_by = $lead['clm_addedbyname'];
                                          $date = $lead['clm_sdate_n'];
                                          $id = base64_encode($lead['clm_id']);

                                          $url = get_module_path() . "leads/reject_lead/?ref_id=$id";
                                          $confirm = get_module_path() . "customers/confirm_lead/?ref_id=$id";

                                          $title = $name . " - " . $date . " - " . $added_by;
                                       ?>

                                          <li>
                                             <div class="col1">
                                                <div class="cont">

                                                   <div class="cont-col1">
                                                      <div class="label label-sm label-success">
                                                         <i class="fa fa-clock-o"></i>
                                                      </div>
                                                   </div>

                                                   <div class="cont-col2">
                                                      <a
                                                         data-id="<?php echo $id; ?>"
                                                         data-href="<?php echo $url; ?>"
                                                         data-confirm="<?php echo $confirm; ?>"
                                                         data-toggle="modal"
                                                         data-target="#confirm-final">

                                                         <div class="desc" title="<?php echo $title; ?>">
                                                            <?php echo $title; ?>
                                                         </div>

                                                      </a>
                                                   </div>

                                                </div>
                                             </div>
                                          </li>

                                       <?php } ?>

                                    </ul>
                                 </div>
                              </div>
                           </div>

                           <!-- FOOTER -->
                           <div class="scroller-footer">
                              <div class="btn-arrow-link pull-right">
                                 <a href="<?php echo get_module_path() . "leads/lead_report/?status=FS"; ?>" class="lead-approval-seeall">
                                    See All Records
                                    <i class="icon-arrow-right"></i>
                                 </a>
                              </div>
                           </div>

                        </div>
                     </div>
                  </div>
               <?php } ?>

               <!-- END LEAD APPROVAL REQUEST -->
               <!-- BEGIN TODAYS FOLLOW-UP -->
               <?php if ($reminder_name == "TodaysTeamFollowUps" && !empty($todays_followup_list['jsArray'])) { ?>
                  <div class="reminder-item">


                     <!-- BEGIN PORTLET -->
                     <div class="portlet <?php echo $icon_color[$key]; ?> box todays-team-followups">

                        <div class="portlet-title" style="border-bottom:1px solid #eee;">
                           <div class="caption" style="font-weight:600;color:#333;">
                              <i class="<?php echo $icon; ?>" style="color:white;"></i>

                              <?php echo $d_name; ?>
                              <span style="
                              float:right;
                              margin-left:12px;
                              background:#e3f2fd;
                              color:#1565c0;
                              padding:4px 12px;
                              border-radius:14px;
                              font-size:13px;
                              font-weight:600;
                              line-height:1;">
                                 <?php echo $todays_followup_list['total_count']; ?>
                              </span>
                           </div>
                        </div>

                        <div class="portlet-body">
                           <div class="tab-content">
                              <div class="tab-pane active">
                                 <div class="slimScrollDiv">
                                    <ul class="feeds todays-team-list">

                                       <?php foreach ($todays_followup_list['jsArray'] as $followup) {

                                          $name = !empty($followup['clm_name']) ? $followup['clm_name'] : $followup['customer_name'];
                                          $clm_contact = !empty($followup['clm_contact']) ? $followup['clm_contact'] : $followup['customer_contact'];
                                          $date = $followup['followup_date_n'];
                                          $type = "";
                                          if (!empty($followup['quotation_id'])) {
                                             $type = "Quotation";
                                          } else {
                                             $type = !empty($followup['customer_id']) ? "Customer" : "Lead";
                                          }

                                          $url = "";
                                          if (!empty($followup['quotation_id'])) {
                                             $url = get_module_path() . "reports/view_quotation/?history=back&id=" . base64_encode($followup['quotation_id']);
                                          } else {
                                             // $url = !empty($followup['clm_id'])
                                             //    ? get_module_path() . "leads/view_lead/?history=back&id=" . base64_encode($followup['clm_id'])
                                             //    : get_module_path() . "customers/view_customer/?history=back&id=" . base64_encode($followup['customer_id']);
                                             //   add by ritika
                                             $url = !empty($followup['clm_id'])
                                                ? get_module_path() . "leads/view_lead/?history=dashboard&id=" . base64_encode($followup['clm_id'])
                                                : get_module_path() . "customers/view_customer/?history=dashboard&id=" . base64_encode($followup['customer_id']);
                                          }

                                          $title = $name . " - " . $date . " - " . $type;
                                       ?>
                                          <li>
                                             <div class="col1">
                                                <div class="cont">
                                                   <div class="cont-col1">
                                                      <div class="label label-sm label-danger">
                                                         <i class="fa fa-phone"></i>
                                                      </div>
                                                   </div>
                                                   <div class="cont-col2">
                                                      <a href="<?php echo $url; ?>">
                                                         <div class="desc" title="<?php echo $title; ?>">
                                                            <?php echo $title; ?>
                                                         </div>
                                                      </a>
                                                   </div>
                                                </div>
                                             </div>
                                          </li>
                                       <?php } ?>

                                    </ul>
                                 </div>
                              </div>
                           </div>

                           <!-- FOOTER -->
                           <div class="scroller-footer">
                              <!-- 🔴 ADDED team-footer CLASS -->
                              <div class="btn-arrow-link pull-right team-footer">
                                 <a href="<?php echo get_module_path() . "reports/my_followup_report/?date=MY"; ?>"
                                    class="team-followup-seeall">
                                    See All Records
                                    <i class="icon-arrow-right"></i>
                                 </a>
                              </div>
                           </div>

                        </div>
                     </div>
                  </div>
               <?php } ?>

               <!-- END TODAYS FOLLOW-UP -->


               <!-- BEGIN MY FOLLOW-UP -->
               <?php
               if ($reminder_name == "TodaysMyFollowUps" && !empty($my_followup_list['jsArray'])) { ?>
                  <div class="reminder-item">

                     <div class="portlet <?php echo $icon_color[$key]; ?> box todays-my-followups">

                        <!-- HEADER -->
                        <div class="portlet-title" style="border-bottom:1px solid #eee;">
                           <div class="caption" style="font-weight:600;color:#333;">
                              <i class="<?php echo $icon; ?>" style="color:white;"></i>
                              <?php echo $d_name; ?>

                              <span style="
                        float:right;
                        margin-left:12px;
                        background:#e3f2fd;
                        color:#1565c0;
                        padding:4px 12px;
                        border-radius:14px;
                        font-size:13px;
                        font-weight:600;
                        line-height:1;">
                                 <?php echo $my_followup_list['total_count']; ?>
                              </span>
                           </div>
                        </div>

                        <!-- BODY -->
                        <div class="portlet-body">
                           <div class="tab-content">
                              <div class="tab-pane active">
                                 <div class="slimScrollDiv">
                                    <ul class="feeds">

                                       <?php foreach ($my_followup_list['jsArray'] as $followup) {

                                          $name = !empty($followup['clm_name'])
                                             ? $followup['clm_name']
                                             : $followup['customer_name'];

                                          $contact = !empty($followup['clm_contact'])
                                             ? $followup['clm_contact']
                                             : $followup['customer_contact'];

                                          $date = $followup['followup_date_n'];

                                          $type = "";
                                          if (!empty($followup['quotation_id'])) {
                                             $type = "Quotation";
                                          } else {
                                             $type = !empty($followup['customer_id']) ? "Customer" : "Lead";
                                          }

                                          $url = "";
                                          if (!empty($followup['quotation_id'])) {
                                             $url = get_module_path() . "reports/view_quotation/?history=back&id=" . base64_encode($followup['quotation_id']);
                                          } else {
                                             // $url = !empty($followup['clm_id'])
                                             //    ? get_module_path() . "leads/view_lead/?history=back&id=" . base64_encode($followup['clm_id'])
                                             //    : get_module_path() . "customers/view_customer/?history=back&id=" . base64_encode($followup['customer_id']);
                                         $url = !empty($followup['clm_id'])
    ? get_module_path() . "leads/view_lead/?history=dashboard&id=" . base64_encode($followup['clm_id'])
    : get_module_path() . "customers/view_customer/?history=dashboard&id=" . base64_encode($followup['customer_id']);
                                             }

                                          $title = $name . " - " . $date . " - " . $type;
                                       ?>
                                          <li>
                                             <div class="col1">
                                                <div class="cont">
                                                   <div class="cont-col1">
                                                      <div class="label label-sm label-success">
                                                         <i class="fa fa-phone"></i>
                                                      </div>
                                                   </div>
                                                   <div class="cont-col2">
                                                      <a href="<?php echo $url; ?>">
                                                         <div class="desc" title="<?php echo $title; ?>">
                                                            <?php echo $title; ?>
                                                         </div>
                                                      </a>
                                                   </div>
                                                </div>
                                             </div>
                                          </li>
                                       <?php } ?>

                                    </ul>
                                 </div>
                              </div>
                           </div>

                           <!-- FOOTER -->
                           <div class="scroller-footer">
                              <div class="btn-arrow-link pull-right">
                                 <a href="<?php echo get_module_path() . "reports/my_followup_report/?assigned_to=MY"; ?>"
                                    class="my-followup-seeall">
                                    See All Records
                                    <i class="icon-arrow-right"></i>
                                 </a>
                              </div>
                           </div>

                        </div>
                     </div>
                  </div>
               <?php } ?>
               <!-- END MY FOLLOW-UP -->




               <!-- BEGIN CHEQUE REMINDER -->
               <!-- BEGIN CHEQUE REMINDER -->
               <?php
               if ($reminder_name == "PaymentDefaulterCustomers1" && !empty($cheque_reminder_list['jsArray'])) { ?>
                  <div class="reminder-item">


                     <!-- BEGIN PORTLET -->
                     <div class="portlet <?php echo $icon_color[$key]; ?> box payment-defaulter-reminder">

                        <!-- HEADER -->
                        <div class="portlet-title" style="border-bottom:1px solid #2196f3;">
                           <div class="caption" style="font-weight:600;color:#333;">
                              <i class="<?php echo $icon; ?>" style="color:white;"></i>
                              <?php echo $d_name; ?> ( Total- <?php echo count($cheque_reminder_list['jsArray']); ?> )
                           </div>
                        </div>

                        <!-- BODY -->
                        <div class="portlet-body">
                           <div class="tab-content">
                              <div class="tab-pane active">
                                 <div class="slimScrollDiv">
                                    <ul class="feeds">

                                       <?php
                                       foreach ($cheque_reminder_list['jsArray'] as $cheque_reminder) {

                                          $cp_id = $cheque_reminder['cp_id'];
                                          $name = $cheque_reminder['customer_name'];
                                          $contact = $cheque_reminder['customer_contact'];
                                          $cp_amount = $cheque_reminder['cp_amount'];
                                          $cp_chq_date_n = $cheque_reminder['cp_chq_date_n'];

                                          $url = "#";
                                          $icon = "fa fa-phone";
                                          $label = "success";

                                          $title = $name . " - Mob No. - " . $contact .
                                             " - Amount - " . $cp_amount .
                                             " - " . $cp_chq_date_n;
                                       ?>
                                          <li>
                                             <div class="col1">
                                                <div class="cont">

                                                   <div class="cont-col1">
                                                      <div class="label label-sm label-<?php echo $label; ?>">
                                                         <i class="<?php echo $icon; ?>"></i>
                                                      </div>
                                                   </div>

                                                   <div class="cont-col2">
                                                      <a href="<?php echo $url; ?>">
                                                         <div class="desc" title="<?php echo $title; ?>">
                                                            <?php echo $title; ?>
                                                         </div>
                                                      </a>
                                                   </div>

                                                </div>
                                             </div>
                                          </li>
                                       <?php } ?>

                                    </ul>
                                 </div>
                              </div>
                           </div>

                           <!-- FOOTER -->
                           <div class="scroller-footer">
                              <div class="btn-arrow-link pull-right">
                                 <a href="javascript:;" class="payment-defaulter-seeall">
                                    See All Records
                                    <i class="icon-arrow-right"></i>
                                 </a>
                              </div>
                           </div>

                        </div>
                     </div>
                  </div>
               <?php } ?>
               <!-- END CHEQUE REMINDER -->

               <!-- END CHEQUE REMINDER -->
               <!-- BEGIN CHEQUE REMINDER -->
               <!-- BEGIN PAYMENT DEFAULTER -->
               <?php
               if ($reminder_name == "PaymentDefaulterCustomers" && !empty($balance_list['jsArray'])) { ?>
                  <div class="reminder-item">


                     <!-- BEGIN PORTLET -->
                     <div class="portlet <?php echo $icon_color[$key]; ?> box payment-defaulter-reminder">

                        <!-- HEADER -->
                        <div class="portlet-title" style="border-bottom:1px solid #2196f3;">
                           <div class="caption" style="font-weight:600;color:#333;">
                              <i class="fa">&#xf156;</i>
                              <?php echo $d_name; ?>
                              <span style="
                        margin-left:8px;
                        background:#e3f2fd;
                        color:#1565c0;
                        padding:3px 10px;
                        border-radius:12px;
                        font-size:12px;
                        font-weight:600;">
                                 <?php echo $balance_list['total_count']; ?>
                              </span>

                           </div>
                        </div>

                        <!-- BODY -->
                        <div class="portlet-body">
                           <div class="tab-content">
                              <div class="tab-pane active">
                                 <div class="slimScrollDiv">
                                    <ul class="feeds">

                                       <?php
                                       foreach ($balance_list['jsArray'] as $balance) {

                                          $cbpm_id = $balance['cbpm_id'];
                                          $name = $balance['customer_name'];
                                          $cbpm_total_amnt = $balance['cbpm_balance_amnt'];
                                          $cbpm_sdate_n = $balance['cbpm_sdate_n'];
                                          $cbpm_billno = $balance['cbpm_billno'];
                                          $cbpm_pay_next_amount = $balance['cbpm_pay_next_amount'];
                                          $cbpm_pay_next_date = $balance['cbpm_pay_next_date'];
                                          $customer_id = $balance['cbpm_custid'];

                                          $url = get_module_path() . "customers/view_payment/?id=" . base64_encode($customer_id) . "&billno=" . base64_encode($cbpm_billno) . "&history=dashboard";

                                          $icon = "fa fa-bell";
                                          $label = "danger";

                                          if ($cbpm_pay_next_amount === null) {
                                             $title = $name . " - Has Balance Amt - " .
                                                $cbpm_total_amnt . " - (" . $cbpm_sdate_n . ")";
                                          } else {
                                             $title = $name . " - Installment Amt - " .
                                                $cbpm_pay_next_amount . " - (" . $cbpm_pay_next_date . ")";
                                          }
                                       ?>
                                          <li>
                                             <div class="col1">
                                                <div class="cont">

                                                   <div class="cont-col1">
                                                      <div class="label label-sm label-<?php echo $label; ?>">
                                                         <i class="<?php echo $icon; ?>"></i>
                                                      </div>
                                                   </div>

                                                   <div class="cont-col2">
                                                      <a href="<?php echo $url; ?>">
                                                         <div class="desc" title="<?php echo $title; ?>">
                                                            <?php echo $title; ?>
                                                         </div>
                                                      </a>
                                                   </div>

                                                </div>
                                             </div>
                                          </li>
                                       <?php } ?>

                                    </ul>
                                 </div>
                              </div>
                           </div>

                           <!-- FOOTER -->
                           <div class="scroller-footer">
                              <div class="btn-arrow-link pull-right">
                                 <a href="<?php echo get_module_path() . "reports/payment_defaulter_report"; ?>"
                                    class="payment-defaulter-seeall">
                                    See All Records
                                    <i class="icon-arrow-right"></i>
                                 </a>
                              </div>
                           </div>

                        </div>
                     </div>
                  </div>
               <?php } ?>
               <!-- END PAYMENT DEFAULTER -->


               <!-- END CHEQUE REMINDER -->


               <!-- PENDING CUSTOMERS REMINDER -->
               <?php    //echo "<pre/>"; print_r($pending_cust_list);	  
               if ($reminder_name == "Pending Customers" && !empty($pending_cust_list['jsArray'])) { ?>
                  <div class="reminder-item">

                     <!-- BEGIN PORTLET -->
                     <div class="portlet <?php echo $icon_color[$key % count($icon_color)]; ?> box pending-customers-reminder">

                        <div class="portlet-title">
                           <div class="caption">
                              <i class="fa fa-bell"></i>&nbsp;
                              <?php echo $d_name; ?> ( Total- <?php echo count($pending_cust_list['jsArray']); ?> )
                           </div>
                        </div>
                        <div class="portlet-body">
                           <!--BEGIN TABS-->
                           <div class="tab-content">
                              <div class="tab-pane active" class="tab_1_1">
                                 <div class="slimScrollDiv">
                                    <ul class="feeds">
                                       <?php if (!empty($pending_cust_list['jsArray'])) {
                                          foreach ($pending_cust_list['jsArray'] as $cust) {

                                             $customer_id = $cust['customer_id'];
                                             $name = $cust['customer_name'];
                                             $customer_contact = $cust['customer_contact'];
                                             $customer_contact_email = $cust['customer_contact_email'];
                                             $cust_sdate_n = $cust['cust_sdate_n'];

                                             //add by ritika
                                             $url = get_module_path() . "customers/view_customer/?id=" . base64_encode($customer_id) . "&history=dashboard";
                                             // $url = get_module_path() . "customers/view_customer/?id=" . base64_encode($customer_id) . "&history=back";
                                             $icon = "fa fa-bell";
                                             $label = "danger";
                                             $title = $name . " - Mob -  " . $customer_contact . " - (" . $cust_sdate_n . " ) ";
                                       ?>
                                             <li>
                                                <div class="col1">
                                                   <div class="cont">
                                                      <div class="cont-col1">
                                                         <div class="label label-sm label-<?php echo $label; ?>">
                                                            <i class="<?php echo $icon; ?>"></i>
                                                         </div>
                                                      </div>
                                                      <div class="cont-col2">
                                                         <div class="desc" title="<?php echo $title; ?>"><a href="<?php echo $url; ?>">
                                                               <?php echo $title; ?></a></div>
                                                      </div>
                                                   </div>
                                                </div>
                                             </li>
                                          <?php }
                                       } else { ?>
                                          <li>No Data Found </li>
                                       <?php } ?>
                                    </ul>
                                 </div>
                              </div>
                           </div>
                           <div class="scroller-footer">
                              <div class="btn-arrow-link pull-right">
                                 <a href="<?php echo get_module_path() . "customers/customer_report/?status=Pending"; ?>">See All
                                    Records</a>
                                 <i class="icon-arrow-right"></i>
                              </div>
                           </div>
                        </div>
                        <!--END TABS-->
                     </div>
                  </div>
               <?php } ?>
               <!-- END PENDING CUSTOMERS REMINDER -->
               <!-- RAISED COMPLAINTS REMINDER -->
               <?php
               if ($reminder_name == "RaisedComplaints" && !empty($raised_complaint_list['jsArray'])) { ?>
                  <div class="reminder-item">


                     <!-- BEGIN PORTLET -->
                     <div class="portlet <?php echo $icon_color[$key]; ?> box raised-complaints-reminder">

                        <!-- HEADER -->
                        <div class="portlet-title" style="border-bottom:1px solid #f44336;">
                           <div class="caption" style="font-weight:600;color:#333;">
                              <i class="fa fa-exclamation-triangle" style="color:white;"></i>
                              <?php echo $d_name; ?>

                              <span style="
                        float:right;
                        margin-left:12px;
                        background:#fdecea;
                        color:#1565c0;
                        padding:4px 12px;
                        border-radius:14px;
                        font-size:13px;
                        font-weight:600;">
                                 <?php echo count($raised_complaint_list['jsArray']); ?>
                              </span>
                           </div>
                        </div>

                        <!-- BODY -->
                        <div class="portlet-body">
                           <div class="tab-content">
                              <div class="tab-pane active">
                                 <div class="slimScrollDiv">
                                    <ul class="feeds">

                                       <?php foreach ($raised_complaint_list['jsArray'] as $cust) {

                                          $customer_id = $cust['customer_id'];
                                          $name = $cust['customer_name'];
                                          $ticket_title = $cust['ticket_title'];
                                          $ticket_id = $cust['ticket_id'];
                                          $tkt_sdate_n = $cust['tkt_sdate_n'];

                                          $url = get_module_path() . "customers/view_complaint/?id=" . base64_encode($ticket_id) . "&history=dashboard";

                                          $icon = "fa fa-exclamation-triangle";
                                          $label = "danger";

                                          $title = $ticket_title . " - " . $name . " - (" . $tkt_sdate_n . ")";
                                       ?>
                                          <li>
                                             <div class="col1">
                                                <div class="cont">

                                                   <div class="cont-col1">
                                                      <div class="label label-sm label-<?php echo $label; ?>">
                                                         <i class="<?php echo $icon; ?>"></i>
                                                      </div>
                                                   </div>

                                                   <div class="cont-col2">
                                                      <a href="<?php echo $url; ?>">
                                                         <div class="desc" title="<?php echo $title; ?>">
                                                            <?php echo $title; ?>
                                                         </div>
                                                      </a>
                                                   </div>

                                                </div>
                                             </div>
                                          </li>
                                       <?php } ?>

                                    </ul>
                                 </div>
                              </div>
                           </div>

                           <!-- FOOTER -->
                           <div class="scroller-footer">
                              <div class="btn-arrow-link pull-right">
                                 <a href="<?php echo get_module_path() . "customers/complaint_report"; ?>"
                                    class="raised-complaints-seeall">
                                    See All Records
                                    <i class="icon-arrow-right"></i>
                                 </a>
                              </div>
                           </div>

                        </div>
                     </div>
                  </div>
               <?php } ?>
               <!-- END RAISED COMPLAINTS -->


               <!-- END RAISED COMPLAINTS REMINDER -->

               <!-- AMC RENEWAL REMINDER -->
               <?php
               if ($reminder_name == "AmcRenewal" && !empty($amc_reminder['jsArray'])) { ?>
                  <div class="reminder-item">


                     <!-- BEGIN PORTLET -->
                     <div class="portlet <?php echo $icon_color[$key]; ?> box amc-renewal-reminder">

                        <!-- HEADER -->
                        <div class="portlet-title" style="border-bottom:1px solid #f44336;">
                           <div class="caption" style="font-weight:600;color:#333;">
                              <i class="fa fa-clock-o" style="color:white;"></i>
                              <?php echo $d_name; ?>

                              <span style="
                     float:right;
                     margin-left:12px;
                     background:#fdecea;
                     color:#1565c0;
                     padding:4px 12px;
                     border-radius:14px;
                     font-size:13px;
                     font-weight:600;
                     line-height:1;">
                                 <?php echo $amc_reminder['total_count']; ?>
                              </span>
                           </div>
                        </div>

                        <!-- BODY -->
                        <div class="portlet-body">
                           <div class="tab-content">
                              <div class="tab-pane active">
                                 <div class="slimScrollDiv">
                                    <ul class="feeds">

                                       <?php foreach ($amc_reminder['jsArray'] as $cust) {

                                          $amc_name = $cust['amc_name'];
                                          $cust_subs_enddate = date('d-m-Y', strtotime($cust['cust_subs_enddate']));
                                          $customer_name = $cust['customer_name'];
                                          $customer_id = $cust['customer_id'];

                                          // $url = get_module_path() . "customers/view_customer/?id=" . base64_encode($customer_id) . "&history=back";
                                          //   add by ritika
                                          $url = get_module_path() . "customers/view_customer/?id=" . base64_encode($customer_id) . "&history=dashboard";
                                          $title = "Customer - $customer_name, AMC NAME - $amc_name, End Date - $cust_subs_enddate";
                                       ?>
                                          <li>
                                             <div class="col1">
                                                <div class="cont">
                                                   <div class="cont-col1">
                                                      <div class="label label-sm label-danger">
                                                         <i class="fa fa-clock-o"></i>
                                                      </div>
                                                   </div>
                                                   <div class="cont-col2">
                                                      <a href="<?php echo $url; ?>">
                                                         <div class="desc" title="<?php echo $title; ?>">
                                                            <?php echo $title; ?>
                                                         </div>
                                                      </a>
                                                   </div>
                                                </div>
                                             </div>
                                          </li>
                                       <?php } ?>

                                    </ul>
                                 </div>
                              </div>
                           </div>

                           <!-- FOOTER -->
                           <div class="scroller-footer">
                              <div class="btn-arrow-link pull-right">
                                 <a href="<?php echo get_module_path() . "reports/amc_renewal_reminder"; ?>"
                                    class="amc-renewal-seeall">
                                    See All Records
                                    <i class="icon-arrow-right"></i>
                                 </a>
                              </div>
                           </div>

                        </div>
                     </div>
                  </div>
               <?php } ?>
               <!-- END AMC RENEWAL -->

               <!-- END AMC RENEWAL REMINDER -->



               <!-- Nandu 04-12-2025 -->
               <!-- BEGIN PENDING SERVICES -->
               <?php if ($reminder_name == "PendingServices" && !empty($pending_services['jsArray'])) { ?>
                  <div class="reminder-item">


                     <div class="portlet box pending-services-reminder">

                        <!-- HEADER -->
                        <div class="portlet-title">
                           <div class="caption">
                              <i class="fa fa-bullhorn"></i>
                              <?php echo $d_name; ?>

                              <span style="
                        float:right;
                        margin-left:12px;
                        background:#e3f2fd;
                        color:#1565c0;
                        padding:4px 12px;
                        border-radius:14px;
                        font-size:13px;
                        font-weight:600;
                        line-height:1;">
                                 <!-- <?php echo count($pending_services['jsArray']); ?> -->
                                 <?php echo $pending_services['total_count']; ?>
                              </span>
                           </div>
                        </div>

                        <!-- BODY -->
                        <div class="portlet-body">
                           <div class="tab-content">
                              <div class="tab-pane active">
                                 <div class="slimScrollDiv">
                                    <ul class="feeds">

                                       <?php foreach ($pending_services['jsArray'] as $srv) {

                                          $customer_id   = $srv['customer_id'];
                                          $customer_name = $srv['customer_name'];
                                          $service_type  = $srv['cust_serv_type_name'];
                                          $due_date      = $srv['cust_serv_date_n'];

                                          $url = get_module_path() . "customers/view_customer/?id=" . base64_encode($customer_id) . "&history=dashboard";

                                          $title = $customer_name . " - " . $service_type . " - " . $due_date;
                                       ?>

                                          <li>
                                             <div class="col1">
                                                <div class="cont">

                                                   <div class="cont-col1">
                                                      <div class="label label-sm label-danger">
                                                         <i class="fa fa-bullhorn"></i>
                                                      </div>
                                                   </div>

                                                   <div class="cont-col2">
                                                      <a href="<?php echo $url; ?>">
                                                         <div class="desc" title="<?php echo $title; ?>">
                                                            <?php echo $title; ?>
                                                         </div>
                                                      </a>
                                                   </div>

                                                </div>
                                             </div>
                                          </li>

                                       <?php } ?>

                                    </ul>
                                 </div>
                              </div>
                           </div>

                           <!-- FOOTER -->
                           <div class="scroller-footer">
                              <div class="btn-arrow-link pull-right pending-footer">
                                 <a href="<?php echo get_module_path(); ?>customers/upcoming_service_report?auto=pending_services"
                                    class="pending-seeall">
                                    See All Records
                                    <i class="icon-arrow-right"></i>
                                 </a>
                              </div>
                           </div>

                        </div>
                     </div>
                  </div>
               <?php } ?>
               <!-- END PENDING SERVICES -->



               <!-- BEGIN BIRTHDAY REMINDER -->
               <?php if ($reminder_name == "BirthdayReminder" && !empty($birthday_reminder_list['jsArray'])) { ?>

                  <div class="reminder-item">

                     <div class="portlet box birthday-reminder">

                        <!-- HEADER -->
                        <div class="portlet-title">
                           <div class="caption" style="font-weight:600;color:#333;">

                              <i class="fa fa-birthday-cake" style="color:white;"></i>

                              Birthday Reminders

                              <span style="
                    float:right;
                    margin-left:12px;
                    background:#fff3cd;
                    color:#1565c0;
                    padding:4px 12px;
                    border-radius:14px;
                    font-size:13px;
                    font-weight:600;
                    line-height:1;">

                                 <?php echo count($birthday_reminder_list['jsArray']); ?>

                              </span>

                           </div>
                        </div>

                        <!-- BODY -->
                        <div class="portlet-body">

                           <div class="tab-content">
                              <div class="tab-pane active">

                                 <div class="slimScrollDiv">

                                    <ul class="feeds">

                                       <?php foreach ($birthday_reminder_list['jsArray'] as $emp) {

                                          $title =
                                             $emp['name']
                                             . " - "
                                             . $emp['person_type']
                                             . " - "
                                             . $emp['birthday_type'];
                                       ?>

                                          <li>

                                             <div class="col1">

                                                <div class="cont">

                                                   <div class="cont-col1">

                                                      <div class="label label-sm label-warning">

                                                         <i class="fa fa-birthday-cake"></i>

                                                      </div>

                                                   </div>

                                                   <div class="cont-col2">

                                                      <div class="desc" title="<?php echo $title; ?>">

                                                         <?php echo $title; ?>

                                                      </div>

                                                   </div>

                                                </div>

                                             </div>

                                          </li>

                                       <?php } ?>

                                    </ul>

                                 </div>

                              </div>
                           </div>
                           <!-- FOOTER -->
                           <div class="scroller-footer">
                              <div class="btn-arrow-link pull-right">
                                 <a href="<?php echo get_module_path() . "admin/getBirthdayReminder"; ?>"
                                    class="amc-renewal-seeall">
                                    See All Records
                                    <i class="icon-arrow-right"></i>
                                 </a>
                              </div>
                           </div>
                        </div>

                     </div>

                  </div>

               <?php } ?>
               <!-- END BIRTHDAY REMINDER -->




               <!-- OPEN TICKET REMINDER -->
               <?php
               if (
                  isset($reminder_name)
                  && $reminder_name == "TicketReport"
                  && !empty($open_ticket_reminder['jsArray'])
               ) {
               ?>

                  <div class="reminder-item">

                     <div class="portlet red box open-ticket-reminder">

                        <!-- HEADER -->
                        <div class="portlet-title" style="border-bottom:1px solid #4caf50;">
                           <div class="caption" style="font-weight:600;color:#333;">
                              <i class="fa fa-ticket" style="color:white;"></i>
                              Open Tickets

                              <span style="
               float:right;
               margin-left:12px;
               background:#e8f5e9;
               color:#1565c0;
               padding:4px 12px;
               border-radius:14px;
               font-size:13px;
               font-weight:600;
               line-height:1;">
                                 <?php echo (int)$open_ticket_reminder['total_count']; ?>
                              </span>
                           </div>
                        </div>

                        <!-- BODY -->
                        <div class="portlet-body">
                           <div class="tab-content">
                              <div class="tab-pane active">
                                 <div class="slimScrollDiv">
                                    <ul class="feeds">

                                       <?php foreach ($open_ticket_reminder['jsArray'] as $ticket) {

                                          $ticket_id     = $ticket['ticket_id'];
                                          $ticket_seq_id = $ticket['ticket_seq_id'];
                                          $ticket_title  = $ticket['ticket_title'];

                                          $customer_name = !empty($ticket['customer_name'])
                                             ? $ticket['customer_name']
                                             : $ticket['clm_name'];

                                          //  $url = get_module_path() . "customers/view_ticket/?id=" . base64_encode($ticket_id); 
                                    // add bu ritika on 29 june
                                          $url = get_module_path() . "customers/view_ticket/?id=" . base64_encode($ticket_id) . "&history=dashboard";

                                      ?>
                                          <li>
                                             <div class="col1">
                                                <div class="cont">

                                                   <div class="cont-col1">
                                                      <div class="label label-sm label-success">
                                                         <i class="fa fa-ticket"></i>
                                                      </div>
                                                   </div>

                                                   <div class="cont-col2">
                                                      <a href="<?php echo $url; ?>">
                                                         <div class="desc">
                                                            <strong>#<?php echo $ticket_seq_id; ?></strong>
                                                            -
                                                            <?php echo $ticket_title; ?>

                                                            <span>
                                                               -
                                                               <?php echo $customer_name; ?>
                                                            </span>
                                                         </div>
                                                      </a>
                                                   </div>

                                                </div>
                                             </div>
                                          </li>

                                       <?php } ?>

                                    </ul>
                                 </div>
                              </div>
                           </div>

                           <div class="scroller-footer">
                              <div class="btn-arrow-link pull-right">
                                 <a href="<?php echo get_module_path() . "customers/ticket_report"; ?>"
                                    class="amc-renewal-seeall">
                                    See All Records
                                    <i class="icon-arrow-right"></i>
                                 </a>
                              </div>
                           </div>

                        </div>

                     </div>

                  </div>

               <?php } ?>
               <!-- END OPEN TICKET REMINDER -->




         <?php }
         } ?>
         <!-- END PORTLET -->






      </div>
      <!-- END PORTLET-->
   </div>
</div>
<!-- END PAGE BASE CONTENT -->
</div>
</div>
<!-- /.content-wrapper -->
<div class="modal fade" id="confirm-final" tabindex="-1" role="dialog" data-backdrop="static">
   <div class="modal-dialog modal-sm">
      <div class="modal-content">
         <div class="modal-header bg-green-sharp">
            <button type="button" class="close hidden" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title font-white" id="myModalLabel"><i class="font-bold icon-check"></i>&nbsp; Confirm Lead
            </h4>
         </div>
         <div class="modal-body">
            <p id="myModalBody">Are You Sure You Want To Confirm This Lead?</p>
         </div>
         <div class="modal-footer">
            <a class="btn btn-success btn-confirm">Confirm</a>
            <a class="btn btn-danger btn-reject" data-toggle="modal" data-target="#form_modal"
               data-dismiss="modal">Reject</a>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
         </div>
      </div>
   </div>
</div>




<script>
   $(window).on('load', function() {

      // Force scroller to show exactly 3 items + scrollbar
      $('.reminder-item .scroller').each(function() {

         const rowHeight = $(this).find('.feeds li').outerHeight(true);

         if (rowHeight) {
            $(this).css({
               height: rowHeight * 3,
               maxHeight: rowHeight * 3,
               overflowY: 'auto'
            });
         }

      });

   });
</script>

<!-- START MODAL -->
<div class="modal fade" id="form_modal" tabindex="-1" role="basic" aria-hidden="true" data-backdrop="static">
   <div class="modal-dialog modal-md">
      <div class="modal-content">
      </div>
   </div>
</div>
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
   $(document).ready(function() {
      $("#form_modal").on("show.bs.modal", function(e) {
         var link = $(e.relatedTarget);
         $(this).data('bs.modal', null);
         $(this).find(".modal-content").load(link.attr("href"));
      });
      $('#confirm-final').on('show.bs.modal', function(e) {
         $(this).find('.btn-reject').attr('href', $(e.relatedTarget).data('href'));
         $(this).find('.btn-confirm').attr('href', $(e.relatedTarget).data('confirm'));
      });
   });
</script>
