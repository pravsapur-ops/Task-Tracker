<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Task Tracker — Digital Marketing Operations</title>
<style>
*{box-sizing:border-box}
:root{
 --navy:#0f1e4d;--blue:#1e40af;--accent:#3882f6;--bg:#f4f7fb;--white:#fff;
 --text:#172033;--muted:#6b7280;--line:#e5e7eb;--green:#16845b;--greenbg:#dcfce7;
 --orange:#e58b22;--orangebg:#fff4df;--red:#c62828;--redbg:#fee2e2;
}
body{margin:0;font-family:Inter,Arial,sans-serif;background:var(--bg);color:var(--text)}
button,input,select,textarea{font:inherit}
.app{display:flex;min-height:100vh}
.side{position:fixed;z-index:5;width:250px;top:0;bottom:0;background:var(--navy);color:#fff;padding:16px;overflow:auto}
.brand{font-size:22px;font-weight:800;padding:10px 8px 20px}.brand span{color:#60a5fa}
.group{font-size:10px;color:#aab4d0;text-transform:uppercase;margin:17px 8px 6px}
.nav button{width:100%;border:0;background:none;color:#d7def1;text-align:left;padding:9px 10px;border-radius:8px;cursor:pointer;margin:2px 0}
.nav button:hover,.nav button.active{background:#2449a8;color:#fff}
.main{margin-left:250px;width:calc(100% - 250px);padding:22px}
.top{display:flex;justify-content:space-between;align-items:center;margin-bottom:18px;gap:12px}
.top h1{margin:0;font-size:25px}.top p{margin:4px 0;color:var(--muted);font-size:13px}
.user{background:#fff;padding:9px 13px;border-radius:10px;box-shadow:0 2px 10px #0000000a}
.page{display:none}.page.active{display:block}
.cards{display:grid;grid-template-columns:repeat(5,1fr);gap:13px;margin-bottom:16px}
.card,.panel{background:#fff;border-radius:13px;padding:17px;box-shadow:0 2px 12px #0000000b}
.card .label{color:var(--muted);font-size:12px}.card .num{font-size:26px;font-weight:800;margin-top:6px}
.green{color:var(--green)}.red{color:var(--red)}.orange{color:var(--orange)}
.panel{margin-bottom:16px}.head{display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;gap:10px}
.head h2{font-size:17px;margin:0}.head small{color:var(--muted)}
.btn{border:0;background:var(--blue);color:#fff;padding:9px 13px;border-radius:7px;cursor:pointer}.btn:hover{opacity:.92}
.secondary{background:#eef2ff;color:var(--blue)}.success{background:var(--green);color:#fff}.danger{background:#fee2e2;color:#991b1b}
.quick{display:grid;grid-template-columns:repeat(5,1fr);gap:10px}.quick .btn{min-height:42px}
.grid{display:grid;grid-template-columns:1.45fr 1fr;gap:16px}
.table{width:100%;border-collapse:collapse}.table th,.table td{padding:10px 8px;border-bottom:1px solid #edf0f4;text-align:left;font-size:12px;vertical-align:top}.table th{color:var(--muted);font-weight:600}
.badge{padding:4px 8px;border-radius:99px;font-size:10px;font-weight:bold;background:#eef2ff;color:#1d4ed8;display:inline-block}
.ok{background:var(--greenbg);color:#166534}.warn{background:#fef3c7;color:#92400e}.bad{background:var(--redbg);color:#991b1b}.gray{background:#f1f5f9;color:#475569}
.notice{padding:10px;border-left:4px solid var(--blue);background:#f8fafc;margin:8px 0;font-size:12px}

.report-toolbar{display:flex;gap:8px;flex-wrap:wrap;align-items:center;margin:0 0 14px}
.report-toolbar .btn,.report-toolbar select,.report-toolbar input{min-height:40px}
.report-toolbar input,.report-toolbar select{padding:9px;border:1px solid #dbe0e8;border-radius:7px;background:#fff}
.inline-results{margin-top:14px}
.detail-actions{display:flex;gap:8px;flex-wrap:wrap;margin-top:14px}

.filters{display:flex;gap:8px;margin-bottom:13px;flex-wrap:wrap}.filters input,.filters select,.form input,.form select,.form textarea{padding:9px;border:1px solid #dbe0e8;border-radius:7px;background:#fff}
.form{display:grid;grid-template-columns:repeat(2,1fr);gap:11px}.form label{font-size:11px;color:#64748b;font-weight:600}.form input,.form select,.form textarea{width:100%;margin-top:4px}.form textarea{min-height:80px;resize:vertical}.full{grid-column:1/-1}
.calendar{display:grid;grid-template-columns:repeat(7,1fr);gap:6px}.day{min-height:112px;border:1px solid var(--line);border-radius:7px;padding:7px;font-size:11px;background:#fff}.day.today{border:2px solid var(--accent)}.event{margin-top:6px;background:#dbeafe;color:#1e40af;padding:5px;border-radius:5px;font-size:10px}.event.greenEvent{background:#dcfce7;color:#166534}.event.orangeEvent{background:#fef3c7;color:#92400e}
.kpis{display:grid;grid-template-columns:repeat(4,1fr);gap:10px}.kpi{padding:13px;border:1px solid var(--line);border-radius:9px}.kpi b{display:block;font-size:21px;margin-top:5px}
.split{display:grid;grid-template-columns:1fr 1fr;gap:14px}.rolebox{border:1px solid var(--line);padding:13px;border-radius:10px}.rolebox h3{margin:0 0 6px;font-size:14px}.rolebox p{font-size:12px;color:var(--muted);line-height:1.5}
.timeline{border-left:2px solid #dbeafe;margin-left:7px;padding-left:18px}.timeline .item{position:relative;margin:0 0 15px}.timeline .item:before{content:"";position:absolute;left:-25px;top:4px;width:10px;height:10px;border-radius:50%;background:var(--accent)}
.progress{height:8px;background:#eef2f7;border-radius:99px;overflow:hidden}.progress i{display:block;height:100%;background:var(--accent)}
.linkbox{display:flex;gap:7px}.linkbox input{flex:1}
.modal{display:none;position:fixed;inset:0;background:#0b1224aa;z-index:20;align-items:center;justify-content:center;padding:18px}.modal.open{display:flex}.modalCard{background:#fff;border-radius:14px;width:min(760px,96vw);max-height:90vh;overflow:auto;padding:20px}
.toast{position:fixed;right:20px;bottom:20px;background:#111827;color:#fff;padding:12px 15px;border-radius:9px;display:none;z-index:50;box-shadow:0 8px 25px #0003}
.readonly{background:#f8fafc}.clientMode{border:1px solid #bfdbfe;background:#eff6ff;padding:9px;border-radius:8px;color:#1e40af;font-size:12px}
.api{font-family:monospace;font-size:11px;background:#0f172a;color:#dbeafe;border-radius:8px;padding:10px;overflow:auto}
@media(max-width:1050px){.cards{grid-template-columns:repeat(3,1fr)}.quick{grid-template-columns:repeat(3,1fr)}.grid,.split{grid-template-columns:1fr}.kpis{grid-template-columns:repeat(2,1fr)}}
@media(max-width:720px){.side{width:66px}.brand{font-size:0}.brand span{font-size:20px}.nav button{font-size:0;text-align:center}.main{margin-left:66px;width:calc(100% - 66px);padding:12px}.cards,.quick,.kpis{grid-template-columns:repeat(2,1fr)}.calendar{grid-template-columns:repeat(2,1fr)}.form{grid-template-columns:1fr}.full{grid-column:auto}.top{align-items:flex-start;flex-direction:column}.table{min-width:750px}.panel{overflow:auto}}


/* =========================================================
   MOBILE APP UI — MOBILE ONLY
   DESKTOP LAYOUT ABOVE IS NOT CHANGED
   ========================================================= */
@media screen and (max-width: 767px) {
    html, body {
        width: 100%;
        max-width: 100%;
        overflow-x: hidden;
        margin: 0;
        padding: 0;
    }

    body {
        padding-bottom: 76px !important;
        background: #f5f6fb;
    }

    /* Keep the desktop sidebar completely out of the mobile layout. */
    .side,
    .sidebar,
    .side-bar,
    .sidebar-container,
    .desktop-sidebar,
    .main-sidebar {
        display: none !important;
    }

    .app {
        width: 100% !important;
        min-width: 0 !important;
        display: block !important;
    }

    .main {
        margin-left: 0 !important;
        width: 100% !important;
        min-width: 0 !important;
        padding: 0 12px 88px !important;
        box-sizing: border-box;
    }

    /* The desktop top area is replaced by the app header below. */
    .main > .top {
        display: none !important;
    }

    .page {
        width: 100%;
        min-width: 0;
    }

    /* ---------- MOBILE HEADER ---------- */
    .mobile-app-header {
        position: sticky;
        top: 0;
        z-index: 1400;
        width: 100%;
        height: 58px;
        padding: 0 14px;
        box-sizing: border-box;
        background: #ffffff;
        border-bottom: 1px solid #eeeef5;
        display: flex;
        align-items: center;
    }

    .mobile-menu-btn {
        width: 36px;
        height: 36px;
        border: 0;
        background: transparent;
        color: #25263a;
        font-size: 25px;
        line-height: 1;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        -webkit-tap-highlight-color: transparent;
    }

    .mobile-app-brand {
        display: flex;
        align-items: center;
        gap: 8px;
        min-width: 0;
        margin-left: 8px;
    }

    .mobile-app-name {
        color: #1e2034;
        font-size: 15px;
        font-weight: 700;
        white-space: nowrap;
        line-height: 1;
    }

    .mobile-app-logo {
        width: 31px;
        height: 31px;
        border-radius: 8px;
        background: #6956e8;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: -.2px;
        flex: 0 0 auto;
    }

    .mobile-header-actions {
        margin-left: auto;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .mobile-circle-btn,
    .mobile-profile-btn {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        border: 1px solid #e6e7ef;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        padding: 0;
        cursor: pointer;
        box-sizing: border-box;
        -webkit-tap-highlight-color: transparent;
    }

    .mobile-circle-btn {
        color: #202237;
        font-size: 22px;
    }

    .mobile-profile-btn {
        background: #6956e8;
        border-color: #6956e8;
        color: #fff;
        font-size: 15px;
        font-weight: 700;
    }

    .notification-btn {
        font-size: 18px;
    }

    .notification-badge {
        position: absolute;
        top: -4px;
        right: -3px;
        min-width: 18px;
        height: 18px;
        padding: 0 4px;
        border-radius: 20px;
        background: #ff3348;
        color: #fff;
        font-size: 10px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        box-sizing: border-box;
    }

    /* ---------- MOBILE SEARCH ---------- */
    .mobile-search-wrapper {
        position: sticky;
        top: 58px;
        z-index: 1300;
        width: 100%;
        padding: 9px 14px 11px;
        box-sizing: border-box;
        background: #fff;
        border-bottom: 1px solid #f0f1f6;
    }

    .mobile-search {
        width: 100%;
        height: 40px;
        padding: 0 14px;
        box-sizing: border-box;
        border-radius: 22px;
        background: #f4f5fa;
        display: flex;
        align-items: center;
    }

    .mobile-search span {
        margin-right: 9px;
        color: #7d8298;
        font-size: 21px;
        line-height: 1;
    }

    .mobile-search input {
        width: 100%;
        min-width: 0;
        border: 0;
        outline: 0;
        background: transparent;
        color: #24263a;
        font-size: 14px;
    }

    .mobile-search input::placeholder {
        color: #9ca1b4;
    }

    /* ---------- MOBILE SIDE DRAWER ---------- */
    .mobile-menu-overlay {
        position: fixed;
        inset: 0;
        z-index: 1500;
        background: rgba(12, 14, 35, .45);
        opacity: 0;
        visibility: hidden;
        transition: opacity .25s ease, visibility .25s ease;
    }

    .mobile-side-menu {
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        z-index: 1600;
        width: min(84vw, 330px);
        max-width: 330px;
        background: #fff;
        transform: translateX(-105%);
        transition: transform .28s ease;
        overflow-y: auto;
        overflow-x: hidden;
        box-shadow: 10px 0 35px rgba(0,0,0,.12);
        box-sizing: border-box;
        -webkit-overflow-scrolling: touch;
    }

    body.mobile-menu-open .mobile-side-menu {
        transform: translateX(0);
    }

    body.mobile-menu-open .mobile-menu-overlay {
        opacity: 1;
        visibility: visible;
    }

    body.mobile-menu-open {
        overflow: hidden;
    }

    .mobile-menu-header {
        height: 65px;
        padding: 0 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid #eeeef5;
        box-sizing: border-box;
    }

    .mobile-brand {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #1e2034;
        font-size: 17px;
    }

    .mobile-brand-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: #6956e8;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
    }

    .mobile-menu-close {
        width: 34px;
        height: 34px;
        border: 0;
        border-radius: 50%;
        background: #f5f5fa;
        color: #4a4d62;
        font-size: 23px;
        line-height: 1;
        cursor: pointer;
    }

    .mobile-menu-profile {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 16px;
        padding: 14px;
        background: #f6f5ff;
        border-radius: 14px;
    }

    .mobile-profile-large {
        width: 42px;
        height: 42px;
        flex: 0 0 42px;
        border-radius: 50%;
        background: #6956e8;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
    }

    .mobile-menu-profile strong,
    .mobile-menu-profile small {
        display: block;
    }

    .mobile-menu-profile strong {
        color: #222438;
        font-size: 14px;
    }

    .mobile-menu-profile small {
        margin-top: 2px;
        color: #85899d;
        font-size: 12px;
    }

    .mobile-drawer-nav {
        padding: 5px 12px 20px;
    }

    .mobile-drawer-item {
        min-height: 47px;
        width: 100%;
        padding: 0 12px;
        box-sizing: border-box;
        border-radius: 10px;
        display: flex;
        align-items: center;
        gap: 12px;
        color: #34374c;
        text-decoration: none;
        font-size: 14px;
        margin-bottom: 3px;
        position: relative;
        -webkit-tap-highlight-color: transparent;
    }

    .mobile-drawer-item > span:first-child {
        width: 23px;
        flex: 0 0 23px;
        text-align: center;
        color: #6860e8;
        font-size: 18px;
    }

    .mobile-drawer-item > span:nth-child(2) {
        flex: 1;
        min-width: 0;
    }

    .mobile-drawer-item b {
        min-width: 22px;
        height: 20px;
        padding: 0 5px;
        border-radius: 12px;
        background: #ff3348;
        color: #fff;
        font-size: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-sizing: border-box;
    }

    .mobile-drawer-item.active {
        background: #6956e8;
        color: #fff;
    }

    .mobile-drawer-item.active > span:first-child {
        color: #fff;
    }

    .mobile-drawer-footer {
        padding: 12px 16px 24px;
        border-top: 1px solid #eeeef5;
    }

    .mobile-drawer-footer button {
        width: 100%;
        min-height: 44px;
        border: 0;
        border-radius: 10px;
        background: #f6f5ff;
        color: #4b4e63;
        font-size: 14px;
        cursor: pointer;
    }

    /* ---------- MOBILE CONTENT ---------- */
    .cards,
    .quick,
    .kpis {
        grid-template-columns: 1fr !important;
        gap: 12px !important;
    }

    .cards .card,
    .quick > *,
    .kpis > * {
        min-width: 0;
    }

    .grid,
    .split,
    .form {
        grid-template-columns: 1fr !important;
    }

    .full {
        grid-column: auto !important;
    }

    .calendar {
        grid-template-columns: 1fr !important;
    }

    .top {
        align-items: flex-start;
        flex-direction: column;
    }

    .panel {
        width: 100%;
        max-width: 100%;
        overflow-x: auto;
        box-sizing: border-box;
    }

    .table {
        min-width: 700px;
    }

    .modal {
        padding: 10px !important;
        align-items: flex-end !important;
    }

    .modalCard {
        width: 100% !important;
        max-width: 100% !important;
        max-height: 88vh !important;
        border-radius: 16px 16px 0 0 !important;
        padding: 16px !important;
        box-sizing: border-box;
    }

    /* ---------- MOBILE BOTTOM NAV ---------- */
    .mobile-bottom-nav {
        position: fixed;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 1400;
        min-height: 68px;
        padding: 6px 4px calc(6px + env(safe-area-inset-bottom));
        box-sizing: border-box;
        background: rgba(255,255,255,.98);
        border-top: 1px solid #e8e9f1;
        box-shadow: 0 -4px 18px rgba(17,24,39,.07);
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        align-items: stretch;
    }

    .mobile-bottom-item {
        min-width: 0;
        border: 0;
        background: transparent;
        color: #777b91;
        text-decoration: none;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 3px;
        position: relative;
        font-size: 10px;
        font-family: inherit;
        cursor: pointer;
        -webkit-tap-highlight-color: transparent;
    }

    .bottom-icon {
        font-size: 19px;
        line-height: 20px;
    }

    .mobile-bottom-item.active {
        color: #6956e8;
        font-weight: 700;
    }

    .mobile-bottom-badge {
        position: absolute;
        top: 2px;
        right: 18%;
        min-width: 16px;
        height: 16px;
        padding: 0 3px;
        border-radius: 10px;
        background: #ff3348;
        color: #fff;
        font-size: 9px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
    }
}


@media screen and (max-width: 380px) {
    .mobile-app-name { font-size: 14px; }
    .mobile-app-header { padding-left: 10px; padding-right: 10px; }
    .mobile-header-actions { gap: 5px; }
    .mobile-circle-btn, .mobile-profile-btn { width: 36px; height: 36px; }
}

@media screen and (min-width: 768px) {
    .mobile-app-header,
    .mobile-menu-overlay,
    .mobile-side-menu,
    .mobile-search-wrapper,
    .mobile-bottom-nav {
        display: none !important;
    }
}


/* =========================================================
   AUTHENTICATION + ROLE VIEWING
   ========================================================= */
.auth-screen{position:fixed;inset:0;z-index:5000;background:linear-gradient(135deg,#f4f7fb,#eef2ff);display:flex;align-items:center;justify-content:center;padding:22px}
.auth-card{width:min(980px,96vw);display:grid;grid-template-columns:1.05fr .95fr;background:#fff;border-radius:22px;overflow:hidden;box-shadow:0 20px 70px #0f1e4d1c}
.auth-brand{background:linear-gradient(145deg,var(--navy),#243f96);color:#fff;padding:48px;display:flex;flex-direction:column;justify-content:center}
.auth-brand .auth-logo{width:58px;height:58px;border-radius:15px;background:#fff;color:var(--blue);display:flex;align-items:center;justify-content:center;font-weight:900;font-size:20px;margin-bottom:20px}
.auth-brand h1{font-size:34px;margin:0 0 10px}.auth-brand p{color:#dbe6ff;line-height:1.7;margin:0}.auth-points{margin:24px 0 0;padding:0;list-style:none}.auth-points li{margin:10px 0;color:#edf3ff;font-size:13px}
.auth-form{padding:42px}.auth-form h2{margin:0 0 7px;font-size:24px}.auth-form .sub{color:var(--muted);font-size:13px;margin-bottom:22px}.auth-field{margin-bottom:13px}.auth-field label{font-size:12px;font-weight:700;color:#475569;display:block;margin-bottom:5px}.auth-field input{width:100%;padding:12px 13px;border:1px solid #dbe0e8;border-radius:9px;outline:none}.auth-field input:focus{border-color:var(--accent);box-shadow:0 0 0 3px #3882f61a}.auth-login{width:100%;padding:12px;border:0;border-radius:9px;background:var(--blue);color:#fff;font-weight:800;cursor:pointer;margin-top:5px}.demo-logins{margin-top:18px;padding:12px;background:#f8fafc;border:1px solid var(--line);border-radius:10px;font-size:11px;color:#64748b;line-height:1.7}.auth-error{display:none;background:#fee2e2;color:#991b1b;padding:10px;border-radius:8px;font-size:12px;margin-bottom:12px}.app-hidden{display:none!important}
.role-switch-back{display:none}.impersonating .role-switch-back{display:inline-flex}.switch-only-manager{display:inline-flex}
.rolebox-actions{display:flex;gap:9px;flex-wrap:wrap;margin-top:12px}.rolebox-actions .btn{min-width:110px}
@media(max-width:720px){.auth-screen{padding:12px}.auth-card{grid-template-columns:1fr;border-radius:18px}.auth-brand{padding:26px}.auth-brand h1{font-size:27px}.auth-points{display:none}.auth-form{padding:25px 20px}.auth-form h2{font-size:21px}}


/* ================= FRONT-END LOGIN / PORTAL DEMO ================= */
.portal-user-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:12px}
.portal-user-card{border:1px solid var(--line);border-radius:11px;padding:14px;background:#fff}
.portal-user-card.current{border:2px solid var(--accent);background:#f8fbff}
.portal-user-card .portal-user-top{display:flex;justify-content:space-between;align-items:flex-start;gap:10px}
.portal-user-card h3{margin:0 0 4px;font-size:15px}.portal-user-card p{margin:3px 0;color:var(--muted);font-size:11px}
.portal-user-actions{display:flex;gap:7px;flex-wrap:wrap;margin-top:11px}
.demo-note{margin-top:12px;padding:10px;border:1px dashed #cbd5e1;background:#f8fafc;border-radius:8px;color:#64748b;font-size:11px;line-height:1.6}
.view-banner{display:none;margin:0 0 14px;padding:10px 12px;border-radius:9px;background:#eff6ff;border:1px solid #bfdbfe;color:#1e40af;font-size:12px}
body.impersonating .view-banner{display:block}
@media(max-width:720px){.portal-user-grid{grid-template-columns:1fr}.auth-card{max-height:94vh;overflow:auto}}


.client-search-filters select,.member-search-filters select{min-width:190px}.client-search-filters .btn,.member-search-filters .btn{min-width:100px}
@media(max-width:720px){.client-search-filters,.member-search-filters{display:grid;grid-template-columns:1fr;gap:8px}.client-search-filters select,.member-search-filters select,.client-search-filters .btn,.member-search-filters .btn{width:100%;min-width:0}}

/* ================= ENHANCED TASK OPERATIONS ================= */
.page-back-row{display:flex;justify-content:flex-start;margin:0 0 10px}
.page-back-btn{display:none}
.attendance-summary{display:grid;grid-template-columns:repeat(4,1fr);gap:10px;margin-bottom:14px}
.attendance-card{padding:14px;border:1px solid var(--line);border-radius:10px;background:#fff}
.attendance-card b{display:block;font-size:21px;margin-top:5px}
.attendance-tabs{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:12px}
.attendance-tabs .btn.active{background:var(--blue);color:#fff}
.attendance-bot{position:fixed;right:22px;bottom:24px;z-index:1700}
.attendance-bot-toggle{width:58px;height:58px;border:0;border-radius:50%;background:var(--blue);color:#fff;box-shadow:0 12px 28px #0f1e4d33;font-size:25px;cursor:pointer}
.attendance-bot-panel{display:none;position:absolute;right:0;bottom:68px;width:300px;background:#fff;border:1px solid var(--line);border-radius:14px;padding:14px;box-shadow:0 15px 45px #0f1e4d22}
.attendance-bot.open .attendance-bot-panel{display:block}
.attendance-bot-panel h3{margin:0 0 4px;font-size:15px}.attendance-bot-panel p{font-size:11px;color:var(--muted);margin:4px 0 12px}
.attendance-bot-actions{display:flex;gap:8px}.attendance-bot-actions .btn{flex:1}
.attendance-live{padding:9px;background:#f8fafc;border-radius:9px;margin-bottom:10px;font-size:12px}
.approval-toolbar{display:flex;gap:8px;flex-wrap:wrap;align-items:center;margin-bottom:12px}
.approval-toolbar .btn{min-width:140px}
.client-report-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:12px}
.report-client-card{border:1px solid var(--line);border-radius:11px;padding:14px;background:#fff}
.report-client-card h3{margin:0 0 5px;font-size:15px}.report-client-card p{margin:4px 0;color:var(--muted);font-size:12px}
.report-client-card .report-actions{margin-top:11px;display:flex;gap:7px;flex-wrap:wrap}
@media(max-width:900px){.attendance-summary{grid-template-columns:repeat(2,1fr)}.client-report-grid{grid-template-columns:1fr 1fr}}
@media(max-width:720px){
  .attendance-summary{grid-template-columns:1fr 1fr}
  .client-report-grid{grid-template-columns:1fr}
  .attendance-bot{right:12px;bottom:82px}
  .attendance-bot-panel{width:min(300px,calc(100vw - 24px))}
  .page-back-row{margin:4px 0 8px}
  .page-back-btn{display:inline-flex}
}


.calendar-filters select{min-width:180px}.calendar-filters .btn{min-height:40px}
.task-detail-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:10px;margin-bottom:14px}.task-detail-card{border:1px solid var(--line);border-radius:9px;padding:12px;background:#fff}.task-detail-card span{display:block;color:var(--muted);font-size:11px}.task-detail-card b{display:block;margin-top:4px;font-size:14px}
#approvalFilterPanel label{font-size:11px;color:#64748b;font-weight:600}#approvalFilterPanel select,#approvalFilterPanel input{display:block;margin-top:4px;padding:9px;border:1px solid #dbe0e8;border-radius:7px;background:#fff}
@media(max-width:900px){.task-detail-grid{grid-template-columns:repeat(2,1fr)}}
@media(max-width:720px){.calendar-filters{display:grid;grid-template-columns:1fr}.calendar-filters select,.calendar-filters .btn{width:100%;min-width:0}.task-detail-grid{grid-template-columns:1fr}}
</style>
</head>
<body>
<div id="authScreen" class="auth-screen">
  <div class="auth-card">
    <div class="auth-brand">
      <div class="auth-logo">TT</div>
      <h1>Task Tracker</h1>
      <p>Digital Marketing Task Management &amp; Client Delivery</p>
      <ul class="auth-points">
        <li>✓ Manage clients, team members and assignments</li>
        <li>✓ Separate team and client calendars</li>
        <li>✓ Approvals, work proof and performance tracking</li>
        <li>✓ Role-based access for managers, leaders, members and clients</li>
      </ul>
    </div>
    <div class="auth-form">
      <h2>Login to your account</h2>
      <div class="sub">Use your Task Tracker account details to continue.</div>
      <div id="loginError" class="auth-error"></div>
      <form id="loginForm">
        <div class="auth-field"><label>Email address</label><input id="loginEmail" type="email" required placeholder="you@company.com" autocomplete="username"></div>
        <div class="auth-field"><label>Password</label><input id="loginPassword" type="password" required placeholder="Enter password" autocomplete="current-password"></div>
        <button class="auth-login" type="submit">Login</button>
      </form>
      <div class="demo-logins"><b>Demo accounts after setup</b><br>Manager: manager@tasktracker.local / Admin@123<br>Team Leader: leader@tasktracker.local / Admin@123<br>Team Members: ravi@tasktracker.local / Member@123, neha@tasktracker.local / Member@123<br>Clients: clienta@tasktracker.local / Client@123, clientb@tasktracker.local / Client@123</div>
    </div>
  </div>
</div>



<!-- ================= MOBILE APP HEADER ================= -->
<div class="mobile-app-header">
    <button class="mobile-menu-btn" id="mobileMenuBtn" aria-label="Open Task Tracker menu">☰</button>

    <div class="mobile-app-brand" aria-label="Task Tracker">
        <div class="mobile-app-logo"><span>TT</span></div>
        <strong class="mobile-app-name">Task Tracker</strong>
    </div>

    <div class="mobile-header-actions">
        <button class="mobile-circle-btn" aria-label="Create task" type="button" onclick="openModal('taskModal')">+</button>
        <button class="mobile-circle-btn notification-btn" aria-label="Task notifications" type="button" onclick="go('notifications')">
            🔔
            <span class="notification-badge">4</span>
        </button>
        <button class="mobile-profile-btn" type="button" aria-label="Team Leader profile">TL</button>
    </div>
</div>

<!-- ================= MOBILE SIDE DRAWER ================= -->
<div class="mobile-menu-overlay" id="mobileMenuOverlay"></div>
<aside class="mobile-side-menu" id="mobileSideMenu" aria-label="Task Tracker mobile navigation">
    <div class="mobile-menu-header">
        <div class="mobile-brand">
            <div class="mobile-brand-icon">TT</div>
            <strong>Task Tracker</strong>
        </div>
        <button class="mobile-menu-close" id="mobileMenuClose" type="button" aria-label="Close menu">×</button>
    </div>

    <div class="mobile-menu-profile">
        <div class="mobile-profile-large">TL</div>
        <div><strong>Team Leader</strong><small>Task Tracker Admin</small></div>
    </div>

    <nav class="mobile-drawer-nav">
        <a href="#dashboard" class="mobile-drawer-item active" data-page="dashboard"><span>▦</span><span>Dashboard</span></a>
        <a href="#clients" class="mobile-drawer-item" data-page="clients"><span>◉</span><span>Clients</span></a>
        <a href="#tasks" class="mobile-drawer-item" data-page="tasks"><span>✓</span><span>Tasks</span><b>27</b></a>
        <a href="#calendar" class="mobile-drawer-item" data-page="calendar"><span>▦</span><span>Calendars</span></a>
        <a href="#attendance" class="mobile-drawer-item" data-page="attendance"><span>◷</span><span>Attendance</span></a>
        <a href="#approvals" class="mobile-drawer-item" data-page="approvals"><span>◎</span><span>Approvals</span></a>
        <a href="#clientportal" class="mobile-drawer-item" data-page="clientportal"><span>◫</span><span>Client Reports</span></a>
        <a href="#team" class="mobile-drawer-item" data-page="team"><span>♙</span><span>Team Members</span></a>
        <a href="#workload" class="mobile-drawer-item" data-page="workload"><span>▥</span><span>Team Workload</span></a>
        <a href="#bulk" class="mobile-drawer-item" data-page="bulk"><span>⇩</span><span>Bulk Planner</span></a>
        <a href="#performance" class="mobile-drawer-item" data-page="performance"><span>↗</span><span>Work Rates</span></a>
        <a href="#campaigns" class="mobile-drawer-item" data-page="campaigns"><span>◎</span><span>Campaigns &amp; Ads</span></a>
        <a href="#milestones" class="mobile-drawer-item" data-page="milestones"><span>◇</span><span>Client Growth</span></a>
        <a href="#integrations" class="mobile-drawer-item" data-page="integrations"><span>⚙</span><span>Integrations</span></a>
        <a href="#meetings" class="mobile-drawer-item" data-page="meetings"><span>◫</span><span>Meetings</span></a>
        <a href="#notifications" class="mobile-drawer-item" data-page="notifications"><span>🔔</span><span>Notifications</span><b>4</b></a>
    </nav>

    <div class="mobile-drawer-footer">
        <button type="button" id="mobileLogoutBtn">⇥ &nbsp; Logout</button>
    </div>
</aside>

<!-- ================= MOBILE SEARCH ================= -->
<div class="mobile-search-wrapper">
    <div class="mobile-search">
        <span>⌕</span>
        <input type="search" placeholder="Search clients, tasks or team members" aria-label="Search clients, tasks or team members">
    </div>
</div>

<!-- ================= MOBILE BOTTOM NAV ================= -->
<nav class="mobile-bottom-nav" aria-label="Task Tracker quick navigation">
    <a href="#dashboard" class="mobile-bottom-item active" data-page="dashboard"><span class="bottom-icon">▦</span><span>Dashboard</span></a>
    <a href="#tasks" class="mobile-bottom-item" data-page="tasks"><span class="bottom-icon">✓</span><span>Tasks</span><span class="mobile-bottom-badge">27</span></a>
    <a href="#attendance" class="mobile-bottom-item" data-page="attendance"><span class="bottom-icon">◷</span><span>Attendance</span></a>
    <a href="#approvals" class="mobile-bottom-item" data-page="approvals"><span class="bottom-icon">◎</span><span>Approvals</span><span class="mobile-bottom-badge">8</span></a>
    <button type="button" class="mobile-bottom-item" id="mobileMoreBtn" aria-label="Open more Task Tracker options"><span class="bottom-icon">☰</span><span>More</span></button>
</nav>

<div class="app app-hidden" id="appShell">
<aside class="side">
 <div class="brand">Task<span>Tracker Pro</span></div>
 <div class="group">Main</div>
 <div class="nav">
  <button class="active" onclick="go('dashboard',this)">▣ Dashboard</button>
  <button onclick="go('clients',this)">▤ Clients</button>
  <button onclick="go('tasks',this)">✓ Tasks</button>
  <button onclick="go('calendar',this)">▦ Calendars</button>
  <button onclick="go('attendance',this)">◷ Attendance</button>
  <button onclick="go('approvals',this)">◉ Approvals</button>
  <button onclick="go('clientportal',this)">◫ Client Reports</button>
 </div>
 <div class="group">Team Operations</div>
 <div class="nav">
  <button onclick="go('team',this)">♙ Team Members</button>
  <button onclick="go('workload',this)">▥ Workload</button>
  <button onclick="go('bulk',this)">⇩ Bulk Planner</button>
  <button onclick="go('performance',this)">↗ Work Rates</button>
 </div>
 <div class="group">Marketing</div>
 <div class="nav">
  <button onclick="go('campaigns',this)">◎ Campaigns & Ads</button>
  <button onclick="go('milestones',this)">◇ Client Growth</button>
  <button onclick="go('integrations',this)">⚙ Integrations</button>
 </div>
 <div class="group">Communication</div>
 <div class="nav">
  <button onclick="go('meetings',this)">◫ Meetings</button>
  <button onclick="go('notifications',this)">♢ Notifications <span id="notifCount"></span></button>
 </div>
</aside>

<main class="main">
<div class="top">
 <div><h1 id="title">Dashboard</h1><p>Digital Marketing Task Management & Client Delivery</p></div>
 <div class="user"><b id="currentUserName">User</b> · <span id="currentUserRole">User</span> <button class="btn secondary switch-only-manager" style="margin-left:8px" onclick="openRoleSwitcher()">Switch View</button><button class="btn secondary role-switch-back" style="margin-left:8px" onclick="backToMyView()">Back to My View</button><button class="btn secondary" style="margin-left:6px" onclick="logout()">Logout</button></div>
</div>
<div class="view-banner" id="viewBanner"><b>Portal preview:</b> <span id="viewBannerText"></span> <button class="btn secondary" style="margin-left:8px" onclick="backToMyView()">Back to My View</button></div>
<div class="page-back-row"><button class="btn secondary page-back-btn" type="button" onclick="goBack()">← Back to Previous Page</button></div>

<!-- DASHBOARD -->
<section id="dashboard" class="page active">
 <div class="cards">
  <div class="card"><div class="label">Active Clients</div><div class="num">18</div><div class="green">All delivery views live</div></div>
  <div class="card"><div class="label">Today's Team Tasks</div><div class="num">27</div><div class="green">19 completed</div></div>
  <div class="card"><div class="label">Client Approvals</div><div class="num">8</div><div class="orange">Needs attention</div></div>
  <div class="card"><div class="label">Overdue / Blocked</div><div class="num">4</div><div class="red">Team leader follow-up</div></div>
  <div class="card"><div class="label">Scheduled This Month</div><div class="num">146</div><div class="green">Posts + Reels + Ads</div></div>
 </div>
 <div class="panel manager-only-section">
   <div class="head"><h2>Client &amp; Team Setup</h2><span class="badge">Manager / Team Leader</span></div>
   <div class="split">
    <div class="rolebox"><h3>Client Management</h3><div class="rolebox-actions"><button class="btn" onclick="openModal('clientModal')">Add Client</button><button class="btn secondary" onclick="loadClientsPage()">All Clients</button></div></div>
    <div class="rolebox"><h3>Team Member Management</h3><div class="rolebox-actions"><button class="btn" onclick="openModal('teamModal')">Add Member</button><button class="btn secondary" onclick="loadMembersPage()">All Members</button></div></div>
   </div>
  </div>
 <div class="panel">
  <div class="head"><h2>Daily Operations</h2><small>Create, plan, review and report</small></div>
  <div class="quick">
   <button class="btn" onclick="openModal('taskModal')">+ Create Task</button>
   <button class="btn secondary" onclick="openModal('bulkModal')">+ Bulk Month Plan</button>
   <button class="btn secondary" onclick="go('attendance')">Attendance</button>
   <button class="btn" onclick="go('approvals')">Review Approvals</button>
   <button class="btn success" onclick="go('clientReports')">Client Reports</button>
  </div>
 </div>
 <div class="grid">
  <div class="panel"><div class="head"><h2>Today's Team Work</h2><button class="btn secondary" onclick="go('tasks')">View All</button></div>
   <table class="table"><tr><th>Task</th><th>Client</th><th>Assigned</th><th>Due</th><th>Status</th></tr>
   <tr><td>Instagram Reel — Product Launch</td><td>Display Solutions</td><td>Ravi</td><td>10:30 AM</td><td><span class="badge">In Progress</span></td></tr>
   <tr><td>October Content Calendar</td><td>ROAR Engineers</td><td>Priya</td><td>11:00 AM</td><td><span class="badge warn">Client Approval</span></td></tr>
   <tr><td>Meta Ads Creative</td><td>DA Furniture</td><td>Neha</td><td>1:00 PM</td><td><span class="badge">Internal Review</span></td></tr>
   <tr><td>WhatsApp Campaign</td><td>Sri Durga</td><td>Arjun</td><td>3:00 PM</td><td><span class="badge ok">Scheduled</span></td></tr></table>
  </div>
  <div class="panel"><div class="head"><h2>Team Leader Alerts</h2></div>
   <div class="notice"><b>3 tasks need work URL</b><br>Task cannot be closed until proof/link is attached.</div>
   <div class="notice"><b>2 client approvals pending</b><br>Client portal links are active.</div>
   <div class="notice"><b>1 platform connection expires soon</b><br>Meta connection needs attention.</div>
  </div>
 </div>
</section>

<!-- CLIENTS -->
<section id="clients" class="page">
 <div class="panel">
  <div class="head">
   <div><h2>All Clients</h2><small>Search a client to open their individual report.</small></div>
   <div style="display:flex;gap:8px;flex-wrap:wrap">
    <button class="btn secondary" onclick="go('dashboard')">← Back</button>
    <button class="btn" onclick="openModal('clientModal')">+ Add Client</button>
   </div>
  </div>
  <div class="filters client-search-filters">
   <select id="clientFilterSelect" aria-label="Select client"><option value="">Clients</option></select>
   <select id="clientStatusFilter" aria-label="Select client status"><option value="">Status</option><option value="Active">Active</option><option value="On Hold">On Hold</option><option value="Inactive">Inactive</option></select>
   <button class="btn" type="button" onclick="searchClientReport()">Search</button>
  </div>
  <table class="table"><thead><tr><th>Client</th><th>Work Model</th><th>Owner / Experts</th><th>Platforms</th><th>Month Plan</th><th>Client View</th><th>Status</th></tr></thead><tbody id="clientsTableBody"><tr><td colspan="7">Loading clients...</td></tr></tbody></table>
 </div>
</section>

<section id="clientReports" class="page">
 <div class="panel">
  <div class="head"><div><h2>Client Reports</h2><small>Select a client to open the full read-only performance report.</small></div><button class="btn secondary" onclick="goBack()">← Back</button></div>
  <div class="client-report-grid" id="clientReportList"></div>
 </div>
</section>

<section id="clientReport" class="page">
 <div class="panel">
  <div class="head"><div><h2>Client Report</h2><small id="clientReportSubtitle">Individual client details and work report.</small></div><button class="btn secondary" onclick="goBack()">← Back</button></div>
  <div id="clientReportContent"></div>
 </div>
</section>

<!-- TASKS -->
<section id="tasks" class="page">
 <div class="panel"><div class="head"><h2>Task Management</h2><div style="display:flex;gap:8px;align-items:center"><button class="btn secondary" onclick="goBack()">← Back</button><button class="btn" onclick="openModal('taskModal')">+ Create Task</button></div></div>
  <div class="notice"><b>Task closing rule:</b> a team member must attach the completed-work URL/file before marking a task Completed. Then the team leader can verify it and the client can see it in the client portal.</div>
  <div class="filters">
   <select id="taskMemberFilter" aria-label="Filter by member"><option value="">All Members</option><option value="Ravi Kumar">Ravi Kumar</option><option value="Neha Sharma">Neha Sharma</option><option value="Arjun Rao">Arjun Rao</option><option value="Priya Team Leader">Priya Team Leader</option></select>
   <select id="taskPlatformFilter" aria-label="Filter by platform"><option value="">All Platforms</option><option value="Instagram">Instagram</option><option value="YouTube">YouTube</option><option value="WhatsApp">WhatsApp</option><option value="Meta Ads">Meta Ads</option><option value="Facebook">Facebook</option><option value="SEO">SEO</option></select>
   <select id="taskStatusFilter" aria-label="Filter by status"><option value="">All Status</option><option value="Planned">Planned</option><option value="Assigned">Assigned</option><option value="In Progress">In Progress</option><option value="Internal Review">Internal Review</option><option value="Client Approval">Client Approval</option><option value="Revision">Revision</option><option value="Scheduled">Scheduled</option><option value="Published">Published</option><option value="Completed">Completed</option><option value="Delayed">Delayed</option></select>
   <button class="btn" type="button" onclick="searchTasks()">Search</button>
  </div>
  <table class="table" id="taskListTable"><tr><th>Task</th><th>Client / Platform</th><th>Assigned + Approval Tags</th><th>Due</th><th>Proof</th><th>Status</th></tr>
   <tr data-task-row data-member="Ravi Kumar" data-platform="Instagram" data-status="In Progress"><td><a href="#" onclick="openTaskDetail('t-demo-1');return false">20 Instagram Posts</a></td><td>Client A / Instagram</td><td>Ravi<br><span class="badge gray">@TeamLead</span> <span class="badge warn">@ClientApproval</span></td><td>Sep 26</td><td><span class="badge bad">Missing URL</span></td><td><span class="badge">In Progress</span></td></tr>
   <tr data-task-row data-member="Neha Sharma" data-platform="Meta Ads" data-status="Internal Review"><td><a href="#" onclick="openTaskDetail('t-demo-2');return false">Meta Ads Campaign</a></td><td>Client B / Meta Ads</td><td>Neha<br><span class="badge gray">@TeamLead</span> <span class="badge warn">@ClientApproval</span></td><td>Sep 28</td><td><a href="#" onclick="toast('Demo work URL opened');return false">Open proof</a></td><td><span class="badge warn">Internal Review</span></td></tr>
   <tr data-task-row data-member="Arjun Rao" data-platform="WhatsApp" data-status="Scheduled"><td><a href="#" onclick="openTaskDetail('t-demo-3');return false">WhatsApp Broadcast</a></td><td>Client C / WhatsApp</td><td>Arjun<br><span class="badge gray">@TeamLead</span></td><td>Sep 29</td><td><a href="#" onclick="toast('Demo work URL opened');return false">Open proof</a></td><td><span class="badge ok">Scheduled</span></td></tr>
  </table>
 </div>
</section>

<!-- CALENDARS -->
<section id="calendar" class="page">
 <div class="panel">
  <div class="head">
   <div><h2>Team Member Calendar</h2><small>Plan and review internal work by team member, platform and month.</small></div>
   <div style="display:flex;gap:8px;flex-wrap:wrap"><button class="btn secondary" onclick="goBack()">← Back</button><button class="btn" onclick="openModal('contentModal')">+ Add Task</button></div>
  </div>
  <div class="filters calendar-filters">
   <select id="teamCalendarMember"><option value="all">All Team Members</option></select>
   <select id="teamCalendarPlatform"><option value="all">All Platforms</option><option>Instagram</option><option>Meta Ads</option><option>YouTube</option><option>WhatsApp</option></select>
   <select id="teamCalendarMonth"></select>
   <button class="btn" type="button" onclick="searchTeamCalendar()">Search</button>
   <button class="btn secondary" onclick="openModal('bulkModal')">Bulk Upload Month</button>
  </div>
  <div class="notice"><b>TEAM CALENDAR:</b> Internal tasks, preparation deadlines, design/copy work, review deadlines, approvals, publishing time, assigned member and work proof.</div>
  <div id="teamCalendarGrid" class="calendar"></div>
 </div>

 <div class="panel">
  <div class="head"><div><h2>Client Calendar</h2><small>Read-only view of planned and published client work.</small></div></div>
  <div class="filters calendar-filters">
   <select id="clientCalendarClient"><option value="all">All Clients</option></select>
   <select id="clientCalendarPlatform"><option value="all">All Platforms</option><option>Instagram</option><option>Meta Ads</option><option>YouTube</option><option>WhatsApp</option></select>
   <select id="clientCalendarMonth"></select>
   <button class="btn" type="button" onclick="searchClientCalendar()">Search</button>
  </div>
  <div class="notice"><b>CLIENT CALENDAR:</b> Planned/published content, publishing time, status, work link and approval state. Client view is read-only.</div>
  <div id="clientCalendarGrid" class="calendar"></div>
 </div>

 <div class="panel">
  <div class="head"><h2>Work Reports</h2><small>Summary of team and client work for the selected period.</small></div>
  <div class="kpis">
   <div class="kpi">Planned Work<b>146</b><small>This month</small></div>
   <div class="kpi">Completed Work<b>118</b><small class="green">81% completed</small></div>
   <div class="kpi">Pending Review<b>14</b><small>Team / client approval</small></div>
   <div class="kpi">Published<b>94</b><small class="green">Client deliverables</small></div>
  </div>
  <div style="margin-top:14px;overflow:auto">
   <table class="table"><thead><tr><th>Member / Client</th><th>Platform</th><th>Planned</th><th>Completed</th><th>Pending</th><th>Published</th><th>Report</th></tr></thead>
   <tbody>
    <tr><td><b>Ravi Kumar</b></td><td>Instagram</td><td>52</td><td>44</td><td>5</td><td>38</td><td><button class="btn secondary" onclick="previewMember('u3')">View Work</button></td></tr>
    <tr><td><b>Neha Sharma</b></td><td>Meta Ads</td><td>36</td><td>29</td><td>4</td><td>24</td><td><button class="btn secondary" onclick="previewMember('u4')">View Work</button></td></tr>
    <tr><td><b>Arjun Rao</b></td><td>YouTube / WhatsApp</td><td>31</td><td>27</td><td>3</td><td>21</td><td><button class="btn secondary" onclick="previewMember('u5')">View Work</button></td></tr>
    <tr><td><b>Client A</b></td><td>All Platforms</td><td>48</td><td>40</td><td>5</td><td>34</td><td><button class="btn secondary" onclick="previewClient('c1')">Client Report</button></td></tr>
    <tr><td><b>Client B</b></td><td>All Platforms</td><td>41</td><td>34</td><td>4</td><td>29</td><td><button class="btn secondary" onclick="previewClient('c2')">Client Report</button></td></tr>
    <tr><td><b>Client C</b></td><td>All Platforms</td><td>33</td><td>27</td><td>3</td><td>25</td><td><button class="btn secondary" onclick="previewClient('c3')">Client Report</button></td></tr>
   </tbody></table>
  </div>
 </div>
</section>

<!-- TASK DETAIL -->
<section id="taskDetail" class="page">
 <div class="panel">
  <div class="head"><div><h2>Task Details</h2><small id="taskDetailSubtitle">Selected task</small></div><button class="btn secondary" onclick="goBack()">← Back</button></div>
  <div id="taskDetailContent"></div>
 </div>
</section>

<!-- ATTENDANCE -->
<section id="attendance" class="page">
 <div class="panel">
  <div class="head"><div><h2>Team Attendance</h2><small id="attendanceDateLabel">Today's attendance</small></div><button class="btn secondary" onclick="goBack()">← Back</button></div>
  <div class="attendance-summary">
   <div class="attendance-card">Present<b id="attPresentCount">4</b><small>Reported today</small></div>
   <div class="attendance-card">Late<b id="attLateCount">1</b><small>Needs review</small></div>
   <div class="attendance-card">On Leave<b id="attLeaveCount">0</b><small>Upcoming / today</small></div>
   <div class="attendance-card">Working Now<b id="attWorkingCount">2</b><small>Currently active</small></div>
  </div>
  <div class="attendance-tabs">
   <button class="btn active" type="button" onclick="showAttendanceTab('today')">Today</button>
   <button class="btn secondary" type="button" onclick="showAttendanceTab('months')">Past Months</button>
   <button class="btn secondary" type="button" onclick="showAttendanceTab('leave')">Upcoming Leaves</button>
   <button class="btn secondary" type="button" onclick="showAttendanceTab('reports')">Reports</button>
  </div>
  <div id="attendanceTodayPanel">
   <table class="table"><thead><tr><th>Team Member</th><th>Status</th><th>Punch In</th><th>Punch Out</th><th>Task Tracker Time</th><th>Current Work</th></tr></thead>
   <tbody id="attendanceTodayBody"></tbody></table>
  </div>
  <div id="attendanceMonthsPanel" style="display:none">
   <div class="notice">Select any past, present or future month and a team member. The report opens after you click <b>Open Monthly Report</b>.</div>
   <div class="form"><label>Month<select id="attendanceMonthSelect"></select></label><label>Member<select id="attendanceMemberSelect"><option value="all">All Members</option></select></label></div>
   <div style="margin-top:12px"><button class="btn" onclick="openAttendanceMonthlyReport()">Open Monthly Report</button></div>
   <div id="attendanceMonthlyReport" style="display:none;margin-top:16px"></div>
  </div>
  <div id="attendanceLeavePanel" style="display:none"><table class="table"><tr><th>Member</th><th>Leave Date</th><th>Leave Type</th><th>Reason</th><th>Status</th></tr><tr><td>Neha Sharma</td><td>Oct 3, 2026</td><td>Casual Leave</td><td>Personal work</td><td><span class="badge warn">Upcoming</span></td></tr><tr><td>Arjun Rao</td><td>Oct 12, 2026</td><td>Planned Leave</td><td>Family event</td><td><span class="badge warn">Upcoming</span></td></tr></table></div>
  <div id="attendanceReportsPanel" style="display:none"><div class="kpis"><div class="kpi">Average Hours<b>7h 42m</b></div><div class="kpi">On-time Rate<b>92%</b></div><div class="kpi">Task Tracker Active<b>6h 18m</b></div><div class="kpi">Leave Days<b>3</b></div></div><div class="panel" style="padding:0;box-shadow:none;margin-top:14px"><table class="table"><tr><th>Member</th><th>Days Present</th><th>Total Hours</th><th>App Time</th><th>Tasks Completed</th></tr><tr><td>Ravi Kumar</td><td>22</td><td>168h</td><td>143h</td><td>108</td></tr><tr><td>Neha Sharma</td><td>21</td><td>161h</td><td>137h</td><td>89</td></tr><tr><td>Arjun Rao</td><td>23</td><td>174h</td><td>148h</td><td>76</td></tr></table></div></div>
 </div>
</section>

<!-- APPROVALS -->
<section id="approvals" class="page">
 <div class="panel"><div class="head"><div><h2>Approval Center</h2><small>Review pending and previously completed approvals.</small></div><button class="btn secondary" onclick="goBack()">← Back</button></div>
  <div class="approval-toolbar">
   <button class="btn" onclick="openModal('approvalModal')">+ New Approval Chain</button>
   <button class="btn secondary" onclick="openApprovalFilter('month')">Month Wise</button>
   <button class="btn secondary" onclick="openApprovalFilter('date')">Date Wise</button>
   <button class="btn secondary" onclick="showApprovalHistory()">Search Old Approvals</button>
  </div>
  <div id="approvalFilterPanel" style="display:none;margin-top:14px" class="notice">
   <div style="display:flex;gap:8px;flex-wrap:wrap;align-items:end">
    <label id="approvalMonthWrap" style="display:none">Month<select id="approvalMonthSelect"></select></label>
    <label id="approvalDateWrap" style="display:none">Date<input id="approvalDateSelect" type="date"></label>
    <button class="btn" onclick="runApprovalFilter()">Search Approvals</button>
   </div>
  </div>
  <div class="notice"><b>Approval tagging:</b> while assigning a task, tag every person who must review or approve it. Approval records should retain who approved, when, and whether revision was requested.</div>
  <table class="table"><thead><tr><th>Item</th><th>Client</th><th>Creator</th><th>Approval Chain</th><th>Current Step</th><th>Action</th></tr></thead>
   <tbody id="approvalTableBody">
   <tr><td>October Social Calendar</td><td>Client A</td><td>Ravi</td><td>@Priya → @ClientA</td><td><span class="badge warn">Client Approval</span></td><td><button class="btn success" onclick="toast('Approval recorded')">Approve</button> <button class="btn secondary" onclick="toast('Revision requested')">Revision</button></td></tr>
   <tr><td>Meta Ad Creative</td><td>Client B</td><td>Neha</td><td>@Priya → @ClientB</td><td><span class="badge">Team Review</span></td><td><button class="btn success" onclick="toast('Team review approved')">Approve</button> <button class="btn secondary" onclick="toast('Revision requested')">Revision</button></td></tr>
   </tbody></table>
  <div id="approvalHistory" style="display:none;margin-top:14px"><h3 style="font-size:14px">Old Approval Items</h3><table class="table"><thead><tr><th>Item</th><th>Client</th><th>Approved By</th><th>Date / Time</th><th>Result</th></tr></thead><tbody id="approvalHistoryBody"><tr><td>September Reel Calendar</td><td>Client A</td><td>Priya → Client A</td><td>Sep 24, 2026 · 4:20 PM</td><td><span class="badge ok">Approved</span></td></tr><tr><td>August Meta Campaign</td><td>Client B</td><td>Neha → Priya</td><td>Aug 29, 2026 · 6:10 PM</td><td><span class="badge ok">Approved</span></td></tr></tbody></table></div>
 </div>
</section>

<!-- CLIENT PORTAL / ALL CLIENT REPORTS -->
<section id="clientportal" class="page">
 <div class="panel">
  <div class="head"><div><h2>All Clients Reports</h2><small>Select a client to open that client's complete report.</small></div><button class="btn secondary" onclick="goBack()">← Back</button></div>
  <div class="notice"><b>Client Reports:</b> All client reports are shown here. Click <b>Open Report</b> for the individual client report.</div>
  <div class="client-report-grid" id="allClientReportsList"></div>
 </div>
</section>

<!-- CLIENT REPORT DETAIL -->
<section id="clientReport" class="page">
 <div class="panel">
  <div class="head"><div><h2>Client Report</h2><small id="clientReportSubtitle">Individual client details and work report.</small></div><button class="btn secondary" onclick="goBack()">← Back to All Client Reports</button></div>
  <div id="clientReportContent"></div>
 </div>
</section>

<!-- TEAM -->
<section id="team" class="page">
 <div class="panel">
  <div class="head">
   <div><h2>All Members &amp; Expertise</h2><small>Search a member to open their individual work report.</small></div>
   <div style="display:flex;gap:8px;flex-wrap:wrap"><button class="btn secondary" onclick="go('dashboard')">← Back</button><button class="btn" onclick="openModal('teamModal')">+ Add Member</button></div>
  </div>
  <div class="filters member-search-filters">
   <select id="memberFilterSelect" aria-label="Select member"><option value="">Members</option></select>
   <select id="memberStatusFilter" aria-label="Select member status"><option value="">Status</option><option value="Active">Active</option><option value="On Leave">On Leave</option><option value="Inactive">Inactive</option></select>
   <button class="btn" type="button" onclick="searchMemberReport()">Search</button>
  </div>
  <table class="table"><thead><tr><th>Member</th><th>Primary Role</th><th>Platform Expertise</th><th>Client Ownership</th><th>Today</th><th>Week</th><th>Workload</th><th>View</th></tr></thead><tbody id="membersTableBody"><tr><td colspan="8">Loading members...</td></tr></tbody></table>
 </div>
 <div class="panel"><div class="head"><h2>Platform Assignment Matrix</h2></div>
  <table class="table"><tr><th>Platform</th><th>Client A</th><th>Client B</th><th>Client C</th></tr>
   <tr><td>Instagram</td><td>Ravi</td><td>Ravi</td><td>Ravi</td></tr><tr><td>YouTube</td><td>Arjun</td><td>Arjun</td><td>Arjun</td></tr><tr><td>WhatsApp</td><td>Arjun</td><td>Arjun</td><td>Arjun</td></tr><tr><td>Meta Ads</td><td>Neha</td><td>Neha</td><td>Neha</td></tr><tr><td>Client Approval</td><td>Priya + Client</td><td>Priya + Client</td><td>Priya + Client</td></tr>
  </table>
 </div>
</section>

<section id="memberReport" class="page">
 <div class="panel">
  <div class="head"><div><h2>Team Member Report</h2><small id="memberReportSubtitle">Individual member work and performance report.</small></div><button class="btn secondary" onclick="go('team')">← Back to Team Members</button></div>
  <div id="memberReportContent"></div>
 </div>
</section>

<!-- WORKLOAD -->
<section id="workload" class="page">
 <div class="panel"><div class="head"><h2>Team Workload & Advance Planning</h2><span class="badge">Team Leader View</span></div>
  <div class="notice">Team members can schedule their own upcoming work or tasks can be assigned to them in advance. The leader sees planned, active, blocked and completed work in one view.</div>
  <table class="table"><tr><th>Member</th><th>Planned</th><th>Today</th><th>In Progress</th><th>Completed</th><th>Blocked</th><th>Capacity</th></tr>
   <tr><td>Ravi</td><td>34</td><td>6</td><td>4</td><td>22</td><td>2</td><td>78%</td></tr><tr><td>Neha</td><td>28</td><td>5</td><td>3</td><td>19</td><td>1</td><td>65%</td></tr><tr><td>Arjun</td><td>24</td><td>4</td><td>2</td><td>19</td><td>0</td><td>58%</td></tr>
  </table>
 </div>
</section>

<!-- BULK -->
<section id="bulk" class="page">
 <div class="panel"><div class="head"><h2>Bulk Monthly Planner</h2><div class="report-toolbar" style="margin:0"><button class="btn" onclick="openModal('bulkModal')">Upload / Import Calendar</button><button class="btn secondary" onclick="goBack()">← Back</button></div></div>
  <div class="split">
   <div class="rolebox"><h3>Before the month starts</h3><p>Upload one CSV/Excel planning file for each client. It can contain date, time, platform, content type, topic, assigned member, approval chain, status and asset URL.</p><button class="btn secondary" onclick="downloadTemplate()">Download CSV Template</button></div>
   <div class="rolebox"><h3>During the month</h3><p>Add sudden posts, urgent videos, client requests, campaigns or revision tasks without changing the already approved monthly plan.</p><button class="btn" onclick="openModal('contentModal')">+ Add Task</button></div>
  </div>
  <div style="margin-top:14px" class="api">date,time,client,platform,content_type,title,assigned_to,approval_chain,status,work_url</div>
 </div>
</section>

<!-- PERFORMANCE -->
<section id="performance" class="page">
 <div class="panel"><div class="head"><h2>Work Rates — Team Report</h2><div class="report-toolbar" style="margin:0"><select id="workRatePeriod"><option value="daily">Daily Report</option><option value="weekly">Weekly Report</option><option value="monthly" selected>Monthly Report</option><option value="yearly">Yearly Report</option></select><select id="workRateMonth"><option value="2026-09">September 2026</option><option value="2026-08">August 2026</option><option value="2026-07">July 2026</option></select><button class="btn" onclick="searchWorkRates()">Search</button><button class="btn secondary" onclick="goBack()">← Back</button></div></div>
  <div id="workRateReport">
   <div class="kpis"><div class="kpi">Daily completed<b>19</b></div><div class="kpi">Weekly completed<b>96</b></div><div class="kpi">Monthly completed<b>382</b></div><div class="kpi">Yearly completed<b>3,846</b></div></div>
   <h3 style="font-size:14px;margin-top:20px">Team Member Output</h3>
   <table class="table"><tr><th>Member</th><th>Today</th><th>This Week</th><th>This Month</th><th>This Year</th><th>Proof attached</th></tr>
    <tr><td>Ravi</td><td>6</td><td>27</td><td>108</td><td>1,046</td><td>98%</td></tr><tr><td>Neha</td><td>5</td><td>21</td><td>89</td><td>932</td><td>96%</td></tr><tr><td>Arjun</td><td>4</td><td>19</td><td>76</td><td>814</td><td>100%</td></tr>
   </table>
  </div>
 </div>
</section>

<!-- CAMPAIGNS -->
<section id="campaigns" class="page">
 <div class="panel"><div class="head"><h2>Campaigns & Auto Scheduling</h2><div class="report-toolbar" style="margin:0"><button class="btn" onclick="openModal('campaignModal')">+ Create Campaign</button><button class="btn secondary" onclick="go('campaignHistory')">Monthly Campaigns</button><button class="btn secondary" onclick="go('campaignHistory');setTimeout(()=>showCampaignHistory('old'),0)">Old Campaigns</button><button class="btn secondary" onclick="openCampaignSearch()">Search Campaigns</button><button class="btn secondary" onclick="goBack()">← Back</button></div></div>
  <div id="campaignSearchBar" class="report-toolbar" style="display:none"><input id="campaignSearchInput" type="search" placeholder="Search client, platform, campaign or status"><button class="btn" onclick="searchCampaigns()">Search</button><button class="btn secondary" onclick="closeCampaignSearch()">Close</button></div>
  <div class="notice"><b>Important:</b> the app UI can prepare and schedule content, but actual automatic publishing/boosting requires official API connections, permissions and tokens for each client's platform. The Integrations page is where those connections will be managed.</div>
  <table class="table" id="campaignCurrentTable"><tr><th>Client</th><th>Platform</th><th>Type</th><th>Schedule</th><th>Connection</th><th>Status</th></tr>
   <tr><td>Client A</td><td>Instagram</td><td>Posts + Reels</td><td>Auto schedule 11 AM</td><td><span class="badge ok">Connected</span></td><td><span class="badge ok">Active</span></td></tr>
   <tr><td>Client B</td><td>Meta Ads</td><td>Campaign</td><td>Launch Sep 28 4 PM</td><td><span class="badge ok">Connected</span></td><td><span class="badge">Ready</span></td></tr>
   <tr><td>Client C</td><td>YouTube</td><td>Video</td><td>Sep 29 6 PM</td><td><span class="badge warn">Needs OAuth</span></td><td><span class="badge warn">Waiting</span></td></tr>
  </table>
 </div>
</section>

<section id="campaignHistory" class="page">
 <div class="panel"><div class="head"><div><h2>Campaign History</h2><small id="campaignHistorySubtitle">Monthly and past campaign records.</small></div><div class="report-toolbar" style="margin:0"><button class="btn secondary" onclick="go('campaigns')">← Back to Campaigns</button></div></div>
  <div class="report-toolbar"><select id="campaignMonthSelect"><option value="2026-09">September 2026</option><option value="2026-08">August 2026</option><option value="2026-07">July 2026</option><option value="2026-06">June 2026</option></select><select id="campaignHistoryMode"><option value="monthly">Monthly Wise</option><option value="old">All Old Campaigns</option></select><input id="campaignHistorySearch" type="search" placeholder="Search campaign/client/platform"><button class="btn" onclick="searchCampaignHistory()">Search</button></div>
  <div id="campaignHistoryResults" class="inline-results"></div>
 </div>
</section>

<section id="campaignDetail" class="page">
 <div class="panel"><div class="head"><div><h2>Campaign Details</h2><small id="campaignDetailSubtitle">Individual campaign record.</small></div><button class="btn secondary" onclick="goBack()">← Back</button></div><div id="campaignDetailContent"></div></div>
</section>

<!-- MILESTONES -->
<section id="milestones" class="page">
 <div class="panel"><div class="head"><h2>Client Platform Improvement Timeline</h2><div class="report-toolbar" style="margin:0"><select id="growthClientSelect"><option value="">Select Client</option><option value="c1">Client A</option><option value="c2">Client B</option><option value="c3">Client C</option></select><button class="btn" onclick="searchClientGrowth()">Search</button><button class="btn secondary" onclick="goBack()">← Back</button></div></div>
  <div class="kpis"><div class="kpi">Views<b id="growthViews">48.6K</b><small class="green">+23%</small></div><div class="kpi">Leads<b id="growthLeads">186</b><small class="green">+22%</small></div><div class="kpi">Likes<b id="growthLikes">3,920</b><small class="green">+18%</small></div><div class="kpi">Followers<b id="growthFollowers">12.8K</b><small class="green">+9%</small></div></div>
  <div class="timeline" style="margin-top:20px" id="growthTimeline">
   <div class="item"><b>Sep 24 — Instagram milestone</b><br>48.6K views and 3,920 likes after the September content plan.</div>
   <div class="item"><b>Sep 15 — Lead milestone</b><br>Meta campaigns generated 186 tracked leads.</div>
   <div class="item"><b>Aug 31 — Monthly baseline</b><br>39.4K views, 152 leads and 5.9% engagement.</div>
   <div class="item"><b>Jul 31 — Starting baseline</b><br>31.2K views, 131 leads and 5.2% engagement.</div>
  </div>
 </div>
</section>

<!-- INTEGRATIONS -->
<section id="integrations" class="page">
 <div class="panel"><div class="head"><h2>Platform Integrations</h2><div class="report-toolbar" style="margin:0"><button class="btn" onclick="openModal('integrationModal')">+ Connect Platform</button><button class="btn secondary" onclick="goBack()">← Back</button></div></div>
  <div class="notice">Use official APIs/OAuth connections. Store tokens securely on the server; never put long-lived client access tokens directly in this HTML file.</div>
  <div class="report-toolbar"><select id="integrationClientSelect"><option value="">Select Client</option></select><button class="btn" onclick="searchClientIntegrations()">Search</button></div>
  <table class="table"><tr><th>Platform</th><th>Purpose</th><th>Client Accounts</th><th>Status</th><th>Available Actions</th></tr>
   <tr><td>Meta / Instagram</td><td>Posts, Reels, Insights, Leads, Ads</td><td>12</td><td><span class="badge ok">8 Connected</span></td><td>Schedule · Publish · Insights</td></tr>
   <tr><td>Google Ads</td><td>Campaigns, spend, leads, conversions</td><td>7</td><td><span class="badge ok">5 Connected</span></td><td>Campaign sync · Reporting</td></tr>
   <tr><td>YouTube</td><td>Video publishing, views, likes</td><td>9</td><td><span class="badge warn">OAuth required</span></td><td>Schedule · Analytics</td></tr>
   <tr><td>WhatsApp Business</td><td>Templates, campaigns, replies</td><td>6</td><td><span class="badge warn">API setup</span></td><td>Campaign send · Reports</td></tr>
  </table>
  <div id="clientIntegrationResults" class="inline-results"></div>
 </div>
</section>

<section id="integrationClientReport" class="page">
 <div class="panel"><div class="head"><div><h2>Client Connection Details</h2><small id="integrationClientSubtitle">Individual client platform connections.</small></div><button class="btn secondary" onclick="goBack()">← Back</button></div><div id="integrationClientContent"></div></div>
</section>

<!-- MEETINGS -->
<section id="meetings" class="page">
 <div class="panel"><div class="head"><h2>Meetings</h2><div class="report-toolbar" style="margin:0"><button class="btn" onclick="openModal('meetingModal')">+ Add Meeting</button><button class="btn secondary" onclick="go('meetingHistory');setTimeout(()=>showMeetingHistory('monthly'),0)">Monthly Meetings</button><button class="btn secondary" onclick="go('meetingHistory');setTimeout(()=>showMeetingHistory('date'),0)">Date-wise Meetings</button><button class="btn secondary" onclick="openMeetingSearch()">Search Meetings</button><button class="btn secondary" onclick="goBack()">← Back</button></div></div>
  <div id="meetingSearchBar" class="report-toolbar" style="display:none"><input id="meetingSearchInput" type="search" placeholder="Search meeting, client, participant or date"><button class="btn" onclick="searchMeetings()">Search</button><button class="btn secondary" onclick="closeMeetingSearch()">Close</button></div>
  <table class="table" id="meetingCurrentTable"><tr><th>Date</th><th>Meeting</th><th>Client</th><th>Participants</th><th>Actions</th></tr>
  <tr><td>Sep 25 · 11 AM</td><td>Monthly Content Review</td><td>Client A</td><td>Ravi, Priya, Client A</td><td><button class="btn secondary" onclick="openMeetingDetail('m1')">View</button></td></tr>
  <tr><td>Sep 26 · 3 PM</td><td>Ads Performance Review</td><td>Client B</td><td>Neha, Priya, Client B</td><td><button class="btn secondary" onclick="openMeetingDetail('m2')">View</button></td></tr></table>
  <div id="meetingSearchResults" class="inline-results"></div>
 </div>
</section>

<section id="meetingHistory" class="page">
 <div class="panel"><div class="head"><div><h2>Old Meetings</h2><small id="meetingHistorySubtitle">Monthly and date-wise meeting history.</small></div><button class="btn secondary" onclick="go('meetings')">← Back to Meetings</button></div>
  <div class="report-toolbar"><select id="meetingHistoryMode"><option value="monthly">Monthly Wise</option><option value="date">Date Wise</option></select><select id="meetingMonthSelect"><option value="2026-09">September 2026</option><option value="2026-08">August 2026</option><option value="2026-07">July 2026</option></select><input id="meetingDateSelect" type="date"><input id="meetingHistorySearch" type="search" placeholder="Search meeting/client"><button class="btn" onclick="searchMeetingHistory()">Search</button></div>
  <div id="meetingHistoryResults" class="inline-results"></div>
 </div>
</section>

<section id="meetingDetail" class="page">
 <div class="panel"><div class="head"><div><h2>Meeting Details</h2><small id="meetingDetailSubtitle">Individual meeting record.</small></div><button class="btn secondary" onclick="goBack()">← Back</button></div><div id="meetingDetailContent"></div></div>
</section>

<!-- NOTIFICATIONS -->
<section id="notifications" class="page">
 <div class="panel"><div class="head"><h2>In-App Notifications</h2><button class="btn secondary" onclick="markAllRead()">Mark all read</button></div>
  <div id="notificationList">
   <div class="notice"><b>Client A approved September Reel.</b><br><small>2 minutes ago · Approval Center</small></div>
   <div class="notice"><b>Ravi completed “Product Poster”.</b><br><small>18 minutes ago · Work proof attached</small></div>
   <div class="notice"><b>Client B requested a revision.</b><br><small>35 minutes ago · Meta Ad Creative</small></div>
   <div class="notice"><b>Tomorrow's team workload is 82% planned.</b><br><small>1 hour ago · Workload</small></div>
  </div>
 </div>
</section>
</main>
</div>

<!-- MODALS -->
<div class="modal" id="taskModal"><div class="modalCard">
 <div class="head"><h2>Create / Assign Task</h2><button class="btn secondary" onclick="closeModal('taskModal')">Close</button></div>
 <div class="form">
  <label>Task title<input id="taskTitle" placeholder="e.g. October Instagram Poster"></label>
  <label>Client<select id="taskClient"><option>Client A</option><option>Client B</option><option>Client C</option></select></label>
  <label>Assigned member<select id="taskMember"><option>Ravi Kumar</option><option>Neha Sharma</option><option>Arjun Rao</option><option>Priya Team Leader</option></select></label>
  <label>Publish date<input id="taskPublishDate" type="datetime-local"></label>
  <label>Due date<input id="taskDueDate" type="date"></label>
  <label>Task type<select id="taskType"><option>One Day Task</option><option>Recurring Task</option><option>Daily Recurring</option><option>Weekly Recurring</option><option>Monthly Recurring</option></select></label>
  <label>Approval tags / Approvers<select id="taskApprovers" multiple size="4"><option>Priya Team Leader — Team Leader</option><option>Ravi Kumar — Team Member</option><option>Neha Sharma — Team Member</option><option>Arjun Rao — Team Member</option><option>Client A — Client Approval</option><option>Client B — Client Approval</option><option>Client C — Client Approval</option></select></label>
  <label class="full">Task notes<textarea id="taskNotes" placeholder="Describe deliverable, caption, creative requirements, campaign objective..."></textarea></label>
  <label>Attachment<input id="taskAttachment" type="file" multiple></label>
  <label>Attachment / Work link<input id="taskAttachmentLink" type="url" placeholder="https://drive.google.com/... or other asset link"></label>
  <label class="full">Work proof URL (required when closing)<input id="taskProofUrl" type="url" placeholder="https://instagram.com/..."></label>
 </div>
 <div style="margin-top:14px;text-align:right"><button class="btn" onclick="saveDemoTask()">Create Task</button></div>
</div></div>

<div class="modal" id="bulkModal"><div class="modalCard">
 <div class="head"><h2>Bulk Monthly Calendar Upload</h2><button class="btn secondary" onclick="closeModal('bulkModal')">Close</button></div>
 <p style="font-size:12px;color:#64748b">Prepare the month before publishing. One file can contain many clients, or upload one file per client.</p>
 <div class="form">
  <label>Client<select id="bulkClient"><option>Client A</option><option>Client B</option><option>Client C</option><option>All Clients</option></select></label>
  <label>Month<select id="bulkMonthSelect"></select></label>
  <label class="full">CSV / Excel file<input id="bulkFile" type="file" accept=".csv,.xlsx,.xls"></label>
  <label class="full">Optional import notes<textarea id="bulkNotes" placeholder="Map columns, default approval chain, default team member..."></textarea></label>
 </div>
 <div style="margin-top:14px;text-align:right"><button class="btn" onclick="importBulkCalendar()">Import Calendar</button></div>
</div></div>

<div class="modal" id="contentModal"><div class="modalCard">
 <div class="head"><h2>Add / Schedule Content</h2><button class="btn secondary" onclick="closeModal('contentModal')">Close</button></div>
 <div class="form">
  <label>Client<select id="contentClient"><option>Client A</option><option>Client B</option><option>Client C</option></select></label>
  <label>Platform<select id="contentPlatform"><option>Instagram</option><option>YouTube</option><option>WhatsApp</option><option>Meta Ads</option></select></label>
  <label>Content type<select id="contentType"><option>Poster</option><option>Carousel</option><option>Reel</option><option>Video</option><option>Ad</option></select></label>
  <label>Publish date/time<input id="contentPublish" type="datetime-local"></label>
  <label>Assigned member<select id="contentMember"><option>Ravi</option><option>Neha</option><option>Arjun</option></select></label>
  <label>Approval chain<input id="contentApproval" placeholder="@TeamLead → @ClientA"></label>
  <label class="full">Asset / Work URL<input id="contentWorkUrl" placeholder="https://drive.google.com/..."></label>
 </div>
 <div style="margin-top:14px;text-align:right"><button class="btn success" onclick="saveCalendarContent()">Add to Calendar</button></div>
</div></div>

<div class="modal" id="clientModal"><div class="modalCard">
 <div class="head"><h2>Add New Client</h2><button class="btn secondary" onclick="closeModal('clientModal')">Close</button></div>
 <div class="form">
  <label>Company name<input id="clientCompanyName" required placeholder="Company name"></label>
  <label>Client name<input id="clientName" required placeholder="Client / contact name"></label>
  <label>Contact no<input id="clientContactNo" placeholder="+91..."></label>
  <label>Email ID<input id="clientEmail" type="email" placeholder="client@email.com"></label>
  <label>Website<input id="clientWebsite" placeholder="https://..."></label>
  <label>WhatsApp no<input id="clientWhatsapp" placeholder="+91..."></label>
  <label>Status<select id="clientStatus"><option>Active</option><option>On Hold</option><option>Inactive</option></select></label>
  <label>Platforms<input id="clientPlatforms" placeholder="Instagram, YouTube, WhatsApp, Meta Ads"></label>
  <label>Monthly deliverables<input id="clientDeliverables" placeholder="20 posts, 4 reels, 2 videos"></label>
  <label>Assigned member<input id="clientOwner" placeholder="Member name"></label>
  <label class="full">Notes<textarea id="clientNotes" placeholder="Client requirements, approval process, reporting notes..."></textarea></label>
 </div>
 <div style="margin-top:14px;text-align:right"><button class="btn" onclick="saveClient()">Add Client</button></div>
</div></div>

<div class="modal" id="roleModal"><div class="modalCard">
  <div class="head"><div><h2>Choose User Portal</h2><small>Managers and Team Leaders can preview all user portals.</small></div><button class="btn secondary" onclick="closeModal('roleModal')">Close</button></div>
  <div class="notice">Select a specific Manager, Team Leader, Team Member or Client. The selected portal is a front-end preview for this HTML prototype.</div>
  <div id="portalUserGrid" class="portal-user-grid"></div>
  <div class="demo-note"><b>Access rule:</b> Managers and Team Leaders can switch into other users for review. Team Members and Clients cannot open another user's portal.</div>
  <div style="margin-top:14px;text-align:right"><button class="btn secondary" onclick="backToMyView();closeModal('roleModal')">Back to My View</button></div>
 </div></div>

<div class="modal" id="approvalModal"><div class="modalCard">
 <div class="head"><h2>Create Approval Chain</h2><button class="btn secondary" onclick="closeModal('approvalModal')">Close</button></div>
 <div class="form">
  <label>Client<select id="approvalClient"><option>Client A</option><option>Client B</option><option>Client C</option></select></label>
  <label>Task / Deliverable<input id="approvalItem" placeholder="October Reel"></label>
  <label class="full">Tag approvers<input id="approvalTags" placeholder="@Designer → @TeamLead → @ClientA"></label>
  <label class="full">Approval rule<select id="approvalRule"><option>All tagged members must approve</option><option>Team leader then client</option><option>Team leader only</option></select></label>
 </div>
 <div style="margin-top:14px;text-align:right"><button class="btn" onclick="saveApproval()">Create Chain</button></div>
</div></div>

<div class="modal" id="campaignModal"><div class="modalCard">
 <div class="head"><h2>Create Campaign / Auto Schedule</h2><button class="btn secondary" onclick="closeModal('campaignModal')">Close</button></div>
 <div class="form">
  <label>Client<select id="campaignClient"><option>Client A</option><option>Client B</option><option>Client C</option></select></label>
  <label>Platform<select id="campaignPlatform"><option>Instagram</option><option>Meta Ads</option><option>Google Ads</option><option>YouTube</option><option>WhatsApp</option></select></label>
  <label>Start<input id="campaignStart" type="datetime-local"></label><label>End<input id="campaignEnd" type="datetime-local"></label>
  <label>Type<select id="campaignType"><option>Campaign</option><option>Posts + Reels</option><option>Video</option><option>Reels</option><option>Ad</option></select></label>
  <label class="full">Campaign title<input id="campaignTitle" placeholder="September Lead Generation"></label>
  <label class="full">Schedule rule<input id="campaignSchedule" placeholder="Every weekday at 11:00 AM"></label>
  <label class="full">Objective<textarea id="campaignObjective" placeholder="Campaign objective"></textarea></label>
 </div>
 <div style="margin-top:14px;text-align:right"><button class="btn success" onclick="saveCampaign()">Save Schedule</button></div>
</div></div>

<div class="modal" id="teamModal"><div class="modalCard">
 <div class="head"><h2>Add Team Member</h2><button class="btn secondary" onclick="closeModal('teamModal')">Close</button></div>
 <div class="form">
  <label>Full name<input id="memberName" required placeholder="Team member name"></label>
  <label>Phone no<input id="memberPhone" placeholder="+91..."></label>
  <label>Login email<input id="memberEmail" type="email" required placeholder="member@company.com"></label>
  <label>WhatsApp no<input id="memberWhatsapp" placeholder="+91..."></label>
  <label>Role<select id="memberRole"><option>Team Member</option><option>Team Leader</option><option>Manager</option></select></label>
  <label>Status<select id="memberStatus"><option>Active</option><option>On Leave</option><option>Inactive</option></select></label>
  <label>Primary field / expertise<input id="memberField" placeholder="Social Media Manager"></label>
  <label>Platform skills<input id="memberSkills" placeholder="Instagram, Reels, Meta Ads"></label>
  <label class="full">Notes<textarea id="memberNotes" placeholder="Clients, responsibilities, approval permissions..."></textarea></label>
 </div>
 <div style="margin-top:14px;text-align:right"><button class="btn" onclick="saveMember()">Add Member</button></div>
</div></div>

<div class="modal" id="integrationModal"><div class="modalCard">
 <div class="head"><h2>Connect Platform</h2><button class="btn secondary" onclick="closeModal('integrationModal')">Close</button></div>
 <div class="form"><label>Platform<select id="integrationPlatform"><option>Meta / Instagram</option><option>Google Ads</option><option>YouTube</option><option>WhatsApp Business</option></select></label><label>Client<select id="integrationClient"><option>Client A</option><option>Client B</option><option>Client C</option></select></label><label>Client Account<input id="integrationAccount" placeholder="Client A Instagram"></label><label>Status<select id="integrationStatus"><option>Connected</option><option>OAuth required</option><option>API setup</option><option>Not connected</option></select></label><label class="full">Available Actions<input id="integrationActions" placeholder="Schedule · Publish · Insights"></label></div>
 <div class="notice" style="margin-top:12px">Production version should open the official OAuth flow and store encrypted tokens on the backend. This prototype only demonstrates the connection workflow.</div>
 <div style="text-align:right"><button class="btn" onclick="saveIntegration()">Save Connection</button></div>
</div></div>


<div class="modal" id="meetingModal"><div class="modalCard">
 <div class="head"><h2>Add Meeting</h2><button class="btn secondary" onclick="closeModal('meetingModal')">Close</button></div>
 <div class="form">
  <label>Date<input id="meetingDate" type="date"></label>
  <label>Time<input id="meetingTime" type="time"></label>
  <label>Meeting title<input id="meetingTitle" placeholder="Monthly Content Review"></label>
  <label>Client<select id="meetingClient"><option>Client A</option><option>Client B</option><option>Client C</option></select></label>
  <label class="full">Participants<input id="meetingParticipants" placeholder="Ravi, Priya, Client A"></label>
  <label class="full">Agenda<textarea id="meetingAgenda" placeholder="Meeting agenda"></textarea></label>
  <label class="full">Notes<textarea id="meetingNotes" placeholder="Meeting notes"></textarea></label>
  <label class="full">Follow-ups<textarea id="meetingFollowups" placeholder="Action items and follow-ups"></textarea></label>
  <label>Status<select id="meetingStatus"><option>Scheduled</option><option>Completed</option><option>Cancelled</option></select></label>
 </div>
 <div style="margin-top:14px;text-align:right"><button class="btn" onclick="saveMeeting()">Save Meeting</button></div>
</div></div>
<div class="attendance-bot" id="attendanceBot">
 <button class="attendance-bot-toggle" type="button" onclick="toggleAttendanceBot()" aria-label="Attendance punch in and punch out">◷</button>
 <div class="attendance-bot-panel">
  <h3>Attendance Assistant</h3><p>Punch in/out and track your Task Tracker active session.</p>
  <div class="attendance-live"><b id="punchStatus">Not punched in</b><br><span id="punchTime">—</span><br><span id="appSessionTime">App session: 0m</span></div>
  <div class="attendance-bot-actions"><button class="btn success" id="punchInBtn" onclick="punchIn()">Punch In</button><button class="btn secondary" id="punchOutBtn" onclick="punchOut()">Punch Out</button></div>
 </div>
</div>

<div class="toast" id="toast"></div>

<script>
/* =========================================================
   TASK TRACKER — PHP / MYSQL CONNECTED FRONT END
   The UI is backed by PHP/MySQL through api.php.
   localStorage is used only as a short-lived browser cache so the existing UI remains responsive.
   ========================================================= */

const titles={
 dashboard:'Dashboard',clients:'Clients',tasks:'Tasks',calendar:'Calendars',attendance:'Attendance',approvals:'Approval Center',
 clientportal:'Client Reports',clientReports:'Client Reports',taskDetail:'Task Details',team:'Team Members',clientReport:'Client Report',memberReport:'Team Member Report',workload:'Team Workload',bulk:'Bulk Planner',
 performance:'Work Rates',campaigns:'Campaigns & Ads',campaignHistory:'Campaign History',campaignDetail:'Campaign Details',milestones:'Client Growth',integrations:'Integrations',integrationClientReport:'Client Connection Details',
 meetings:'Meetings',meetingHistory:'Old Meetings',meetingDetail:'Meeting Details',notifications:'Notifications'
};

const DEMO_USERS=[
 {id:'u1',name:'Priya',email:'manager@tasktracker.local',password:'Admin@123',role:'manager',roleLabel:'Manager',field:'Digital Marketing Manager',client:'All Clients'},
 {id:'u2',name:'Priya Team Leader',email:'leader@tasktracker.local',password:'Admin@123',role:'team_leader',roleLabel:'Team Leader',field:'Social Media & Client Delivery',client:'All Clients'},
 {id:'u3',name:'Ravi Kumar',email:'ravi@tasktracker.local',password:'Member@123',role:'team_member',roleLabel:'Team Member',field:'Instagram / Social Media',client:'Client A, Client B, Client C'},
 {id:'u4',name:'Neha Sharma',email:'neha@tasktracker.local',password:'Member@123',role:'team_member',roleLabel:'Team Member',field:'Meta Ads / Design',client:'Client A, Client B, Client C'},
 {id:'u5',name:'Arjun Rao',email:'arjun@tasktracker.local',password:'Member@123',role:'team_member',roleLabel:'Team Member',field:'YouTube / WhatsApp',client:'Client A, Client B, Client C'},
 {id:'u6',name:'Client A',email:'clienta@tasktracker.local',password:'Client@123',role:'client',roleLabel:'Client',field:'Client Portal',client:'Client A'},
 {id:'u7',name:'Client B',email:'clientb@tasktracker.local',password:'Client@123',role:'client',roleLabel:'Client',field:'Client Portal',client:'Client B'},
 {id:'u8',name:'Client C',email:'clientc@tasktracker.local',password:'Client@123',role:'client',roleLabel:'Client',field:'Client Portal',client:'Client C'}
];

const DEFAULT_CLIENTS=[
 {id:'c1',name:'Client A',contact_person:'Primary Contact',email:'clienta@tasktracker.local',phone:'+91 90000 00001',work_model:'End-to-End Owner',status:'Active',platforms:'Instagram, YouTube, WhatsApp, Meta Ads',website:'https://example.com',monthly_deliverables:'20 posts, 4 reels, 2 videos',owner:'Ravi Kumar',notes:'Approval through client portal.'},
 {id:'c2',name:'Client B',contact_person:'Primary Contact',email:'clientb@tasktracker.local',phone:'+91 90000 00002',work_model:'Platform Experts',status:'Active',platforms:'Instagram, YouTube, WhatsApp, Meta Ads',website:'https://example.com',monthly_deliverables:'16 posts, 4 reels, 2 campaigns',owner:'Platform Team',notes:'Platform-wise allocation.'},
 {id:'c3',name:'Client C',contact_person:'Primary Contact',email:'clientc@tasktracker.local',phone:'+91 90000 00003',work_model:'Hybrid',status:'Active',platforms:'Instagram, YouTube, WhatsApp',website:'https://example.com',monthly_deliverables:'12 posts, 4 reels, 1 video',owner:'Arjun Rao',notes:'Hybrid delivery model.'}
];

function getClients(){
 const saved=JSON.parse(localStorage.getItem('tt_clients')||'null');
 if(!saved){localStorage.setItem('tt_clients',JSON.stringify(DEFAULT_CLIENTS));return [...DEFAULT_CLIENTS];}
 return saved;
}
function setClients(data){localStorage.setItem('tt_clients',JSON.stringify(data));}
function getMembers(){
 const saved=JSON.parse(localStorage.getItem('tt_members')||'null');
 if(saved) return saved;
 const members=DEMO_USERS.filter(u=>u.role==='team_member'||u.role==='team_leader'||u.role==='manager').map(u=>({id:u.id,name:u.name,email:u.email,phone:'',role:u.roleLabel,field:u.field,skills:u.field,work_model:'Platform Expert',status:'Active',notes:u.client}));
 localStorage.setItem('tt_members',JSON.stringify(members));return members;
}
function setMembers(data){localStorage.setItem('tt_members',JSON.stringify(data));}
function getUsers(){
 const custom=JSON.parse(localStorage.getItem('tt_users')||'[]');
 return [...DEMO_USERS,...custom];
}
function currentUser(){const id=localStorage.getItem('tt_current_user');return getUsers().find(u=>u.id===id)||null;}
function currentView(){const id=localStorage.getItem('tt_view_as');return id?getUsers().find(u=>u.id===id)||null:null;}
function effectiveUser(){return currentView()||currentUser();}
function isManagerOrLeader(){const u=currentUser();return !!u&&['manager','team_leader'].includes(u.role);}
function val(id){const e=document.getElementById(id);return e?e.value.trim():'';}
function esc(s){return String(s??'').replace(/[&<>'"]/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;',"'":'&#39;','"':'&quot;'}[c]));}

let ttPageHistory=[];
let ttCurrentPage='dashboard';
function go(id,btn,skipHistory=false){
 const u=effectiveUser();
 if(!u)return;
 if(u.role==='client' && id!=='clientportal' && id!=='notifications'){toast('Client access is limited to the Client Portal and notifications');id='clientportal';}
 if(u.role==='team_member' && ['clients','team','workload','bulk','performance','campaigns','campaignHistory','campaignDetail','milestones','integrations','integrationClientReport'].includes(id)){toast('This section is available to Managers and Team Leaders');return;}
 if(!skipHistory && ttCurrentPage!==id){ttPageHistory.push(ttCurrentPage);if(ttPageHistory.length>20)ttPageHistory.shift();}
 ttCurrentPage=id;
 document.querySelectorAll('.page').forEach(p=>p.classList.remove('active'));
 const el=document.getElementById(id);if(el)el.classList.add('active');
 const title=document.getElementById('title');if(title)title.textContent=titles[id]||'Task Tracker';
 document.querySelectorAll('.nav button').forEach(b=>b.classList.remove('active'));
 if(btn)btn.classList.add('active');
 document.querySelectorAll('.mobile-drawer-item[data-page],.mobile-bottom-item[data-page]').forEach(item=>item.classList.toggle('active',item.dataset.page===id));
 if(id==='clients')loadClients();
 if(id==='team')loadMembers();
 if(id==='tasks'){populateTaskMemberFilter();populateTaskCreateMembers();}
 if(id==='clientReports')loadClientReportList();
 if(id==='clientReport')renderClientReport(localStorage.getItem('tt_client_preview'));
 if(id==='memberReport')renderMemberReport(localStorage.getItem('tt_member_preview'));
 if(id==='clientportal')renderAllClientReports();
 if(id==='taskDetail')renderTaskDetail(localStorage.getItem('tt_task_preview'));
 if(id==='calendar'){populateCalendarControls();searchTeamCalendar();searchClientCalendar();}
 if(id==='attendance')renderAttendanceToday();
 if(id==='performance')searchWorkRates();
 if(id==='milestones')populateGrowthClients();
 if(id==='integrations')populateIntegrationClients();
 if(id==='campaignHistory')renderCampaignHistory();
 if(id==='meetingHistory')renderMeetingHistory();
 if(id==='campaignDetail')renderCampaignDetail(localStorage.getItem('tt_campaign_preview'));
 if(id==='meetingDetail')renderMeetingDetail(localStorage.getItem('tt_meeting_preview'));
 if(id==='integrationClientReport')renderIntegrationClientReport(localStorage.getItem('tt_integration_client'));
 window.scrollTo({top:0,behavior:'smooth'});
}
function goBack(){
 const previous=ttPageHistory.pop();
 if(previous){go(previous,null,true)}else{go('dashboard',null,true)}
}
function openModal(id){const e=document.getElementById(id);if(e)e.classList.add('open');if(id==='roleModal')renderPortalUsers();}
function closeModal(id){const e=document.getElementById(id);if(e)e.classList.remove('open');}
function toast(msg){const t=document.getElementById('toast');if(!t)return;t.textContent=msg;t.style.display='block';clearTimeout(window.__ttToast);window.__ttToast=setTimeout(()=>t.style.display='none',2600)}
function logout(){localStorage.removeItem('tt_current_user');localStorage.removeItem('tt_view_as');document.body.classList.remove('impersonating');document.getElementById('appShell').classList.add('app-hidden');document.getElementById('authScreen').classList.remove('app-hidden');toast('Logged out');}
function saveDemoTask(){
 const title=val('taskTitle'),client=val('taskClient'),member=val('taskMember'),due=val('taskDueDate'),publish=val('taskPublishDate');
 if(!title||!client||!member||!due||!publish){toast('Please fill Task title, Client, Assigned member, Publish date and Due date');return}
 const approvals=[...document.getElementById('taskApprovers')?.selectedOptions||[]].map(o=>o.text).join(' → ');
 const task={id:'t'+Date.now(),title,client,assigned:member,due,publish,type:val('taskType'),approvals,notes:val('taskNotes'),attachmentLink:val('taskAttachmentLink'),proof:val('taskProofUrl'),created:new Date().toISOString()};
 const tasks=JSON.parse(localStorage.getItem('tt_tasks')||'[]');tasks.push(task);localStorage.setItem('tt_tasks',JSON.stringify(tasks));
 closeModal('taskModal');toast('Task created and assigned');
}
function copyPortalLink(){const u=effectiveUser();const link='https://yourdomain.com/client/'+encodeURIComponent((u?.name||'client').toLowerCase().replace(/\s+/g,'-'));if(navigator.clipboard)navigator.clipboard.writeText(link);toast('Demo client portal link copied: '+link)}
function markAllRead(){document.getElementById('notificationList').innerHTML='<div class="notice"><b>All notifications marked as read.</b></div>';const n=document.getElementById('notifCount');if(n)n.textContent=''}
function attendanceTodayKey(){return new Date().toISOString().slice(0,10)}
function attendanceState(){return JSON.parse(localStorage.getItem('tt_attendance')||'{}')}
function setAttendanceState(s){localStorage.setItem('tt_attendance',JSON.stringify(s))}
function punchIn(){
 const u=effectiveUser();if(!u)return;
 const s=attendanceState(),key=attendanceTodayKey();s[key]=s[key]||{};s[key][u.id]={name:u.name,status:'Present',in:new Date().toISOString(),out:null};setAttendanceState(s);renderAttendanceToday();updatePunchUI();toast('Punched in at '+new Date().toLocaleTimeString());
}
function punchOut(){
 const u=effectiveUser();if(!u)return;const s=attendanceState(),key=attendanceTodayKey(),r=s[key]?.[u.id];if(!r?.in){toast('Punch in first');return}r.out=new Date().toISOString();r.status='Completed';setAttendanceState(s);renderAttendanceToday();updatePunchUI();toast('Punched out at '+new Date().toLocaleTimeString());
}
function updatePunchUI(){
 const u=effectiveUser();if(!u)return;const s=attendanceState(),r=s[attendanceTodayKey()]?.[u.id];const status=document.getElementById('punchStatus'),time=document.getElementById('punchTime');if(!status)return;
 if(r?.in&&!r.out){status.textContent='Punched in — working';time.textContent='Since '+new Date(r.in).toLocaleTimeString();}else if(r?.out){status.textContent='Punched out';time.textContent='Out '+new Date(r.out).toLocaleTimeString();}else{status.textContent='Not punched in';time.textContent='—'}
}
function formatDuration(ms){const mins=Math.max(0,Math.floor(ms/60000));return Math.floor(mins/60)+'h '+String(mins%60).padStart(2,'0')+'m'}
function updateAppSessionTime(){const start=Number(localStorage.getItem('tt_session_start')||Date.now());const e=document.getElementById('appSessionTime');if(e)e.textContent='App session: '+formatDuration(Date.now()-start)}
function toggleAttendanceBot(){document.getElementById('attendanceBot')?.classList.toggle('open');updatePunchUI()}
function renderAttendanceToday(){
 const body=document.getElementById('attendanceTodayBody');if(!body)return;const members=getMembers();const s=attendanceState(),day=s[attendanceTodayKey()]||{};
 body.innerHTML=members.map(m=>{const r=day[m.id];const status=r?.out?'Completed':r?.in?'Working':'Not Reported';const active=r?.in?formatDuration(new Date(r.out||Date.now())-new Date(r.in)):'—';return `<tr><td><b>${esc(m.name)}</b><br><small>${esc(m.role||'Team Member')}</small></td><td><span class="badge ${status==='Working'?'ok':status==='Completed'?'gray':'warn'}">${status}</span></td><td>${r?.in?new Date(r.in).toLocaleTimeString():'—'}</td><td>${r?.out?new Date(r.out).toLocaleTimeString():'—'}</td><td>${active}</td><td>${status==='Working'?'Active task session':'—'}</td></tr>`}).join('');
 const present=Object.values(day).filter(r=>r.in).length,working=Object.values(day).filter(r=>r.in&&!r.out).length;document.getElementById('attPresentCount').textContent=present;document.getElementById('attWorkingCount').textContent=working;document.getElementById('attendanceDateLabel').textContent='Today · '+new Date().toLocaleDateString();
}
function showAttendanceTab(tab){['attendanceTodayPanel','attendanceMonthsPanel','attendanceLeavePanel','attendanceReportsPanel'].forEach(id=>{const e=document.getElementById(id);if(e)e.style.display='none'});const map={today:'attendanceTodayPanel',months:'attendanceMonthsPanel',leave:'attendanceLeavePanel',reports:'attendanceReportsPanel'};document.getElementById(map[tab]).style.display='block';document.querySelectorAll('.attendance-tabs .btn').forEach(b=>b.classList.remove('active'));const btn=[...document.querySelectorAll('.attendance-tabs .btn')].find(b=>b.textContent.toLowerCase().includes(tab==='today'?'today':tab==='months'?'past months':tab==='leave'?'upcoming leaves':'reports'));if(btn)btn.classList.add('active');if(tab==='months'){populateAttendanceMonths();populateAttendanceMembers()}}
function populateAttendanceMonths(){const s=document.getElementById('attendanceMonthSelect');if(!s)return;const now=new Date();let html='';for(let offset=-6;offset<=6;offset++){const d=new Date(now.getFullYear(),now.getMonth()+offset,1);const value=d.getFullYear()+'-'+String(d.getMonth()+1).padStart(2,'0');const type=offset<0?'Past':offset===0?'Present':'Future';html+=`<option value="${value}">${d.toLocaleString('en-US',{month:'long',year:'numeric'})} — ${type} Month</option>`}s.innerHTML=html}
function populateAttendanceMembers(){const s=document.getElementById('attendanceMemberSelect');if(!s)return;s.innerHTML='<option value="all">All Members</option>'+getMembers().map(m=>`<option value="${esc(m.id)}">${esc(m.name)}</option>`).join('')}
function openAttendanceMonthlyReport(){const month=document.getElementById('attendanceMonthSelect')?.value||'';const member=document.getElementById('attendanceMemberSelect')?.value||'all';if(!month){toast('Select a month first');return}const label=new Date(month+'-01T00:00:00').toLocaleString('en-US',{month:'long',year:'numeric'});const members=getMembers().filter(m=>member==='all'||m.id===member);const box=document.getElementById('attendanceMonthlyReport');if(!box)return;box.style.display='block';box.innerHTML=`<div class="kpis"><div class="kpi">Month<b>${esc(label)}</b></div><div class="kpi">Members<b>${members.length}</b></div><div class="kpi">Working Days<b>22</b></div><div class="kpi">Average Hours<b>7h 42m</b></div></div><div style="margin-top:14px;overflow:auto"><table class="table"><tr><th>Member</th><th>Days Present</th><th>Total Hours</th><th>Late Marks</th><th>Leave Days</th><th>Tasks Completed</th></tr>${members.map((m,i)=>`<tr><td>${esc(m.name)}</td><td>${22-i}</td><td>${168-i*7}h</td><td>${i}</td><td>${i?2:1}</td><td>${108-i*19}</td></tr>`).join('')}</table></div>`;toast('Monthly attendance report opened')}
function filterApprovalRows(){return}
function showApprovalHistory(){const e=document.getElementById('approvalHistory');if(e)e.style.display='block';const f=document.getElementById('approvalFilterPanel');if(f)f.style.display='none'}
function openApprovalFilter(type){const f=document.getElementById('approvalFilterPanel');if(!f)return;f.style.display='block';document.getElementById('approvalMonthWrap').style.display=type==='month'?'block':'none';document.getElementById('approvalDateWrap').style.display=type==='date'?'block':'none';populateApprovalMonths();document.getElementById('approvalHistory').style.display='none';f.dataset.mode=type}
function populateApprovalMonths(){const s=document.getElementById('approvalMonthSelect');if(!s)return;const now=new Date();let html='';for(let offset=-6;offset<=6;offset++){const d=new Date(now.getFullYear(),now.getMonth()+offset,1);html+=`<option value="${d.getFullYear()}-${String(d.getMonth()+1).padStart(2,'0')}">${d.toLocaleString('en-US',{month:'long',year:'numeric'})}</option>`}s.innerHTML=html}
function runApprovalFilter(){const f=document.getElementById('approvalFilterPanel');const mode=f?.dataset.mode||'month';const value=mode==='month'?document.getElementById('approvalMonthSelect')?.value:document.getElementById('approvalDateSelect')?.value;if(!value){toast('Select a month or date');return}const history=document.getElementById('approvalHistory'),body=document.getElementById('approvalHistoryBody');if(!history||!body)return;history.style.display='block';body.innerHTML=`<tr><td>${mode==='month'?'Monthly Approval Review':'Date Approval Review'}</td><td>All Clients</td><td>Team Lead → Client</td><td>${esc(value)}</td><td><span class="badge ok">Records Found</span></td></tr>`;toast('Approval records loaded')}
function renderCalendarMode(){return}
function populateBulkMonths(){
 const s=document.getElementById('bulkMonthSelect');if(!s)return;
 const now=new Date(),year=now.getFullYear();
 const start=year===2026?9:0;
 let html='';
 if(year===2026){for(let m=9;m<12;m++)html+=`<option value="${year}-${String(m+1).padStart(2,'0')}">${new Date(year,m,1).toLocaleString('en-US',{month:'long'})} ${year}</option>`;}
 for(let m=0;m<12;m++)html+=`<option value="${year+1}-${String(m+1).padStart(2,'0')}">${new Date(year+1,m,1).toLocaleString('en-US',{month:'long'})} ${year+1}</option>`;
 s.innerHTML=html;
}
const CALENDAR_EVENTS=[
 {id:'t-demo-1',date:'2026-09-26',title:'20 Instagram Posts',client:'Client A',platform:'Instagram',member:'Ravi Kumar',time:'11:00 AM',status:'In Progress',type:'team'},
 {id:'t-demo-2',date:'2026-09-28',title:'Meta Ads Campaign',client:'Client B',platform:'Meta Ads',member:'Neha Sharma',time:'4:00 PM',status:'Internal Review',type:'team'},
 {id:'t-demo-3',date:'2026-09-29',title:'WhatsApp Broadcast',client:'Client C',platform:'WhatsApp',member:'Arjun Rao',time:'3:00 PM',status:'Scheduled',type:'team'},
 {id:'t-demo-4',date:'2026-09-25',title:'YouTube Video',client:'Client A',platform:'YouTube',member:'Arjun Rao',time:'6:00 PM',status:'Scheduled',type:'client'},
 {id:'t-demo-5',date:'2026-09-27',title:'Commercial Display Reel',client:'Client A',platform:'Instagram',member:'Ravi Kumar',time:'11:00 AM',status:'Published',type:'client'},
 {id:'t-demo-6',date:'2026-09-30',title:'October Social Calendar',client:'Client B',platform:'Instagram',member:'Ravi Kumar',time:'2:00 PM',status:'Awaiting Approval',type:'client'}
];
function populateCalendarControls(){const members=document.getElementById('teamCalendarMember');if(members)members.innerHTML='<option value="all">All Team Members</option>'+getMembers().map(m=>`<option value="${esc(m.name)}">${esc(m.name)}</option>`).join('');const clients=document.getElementById('clientCalendarClient');if(clients)clients.innerHTML='<option value="all">All Clients</option>'+getClients().map(c=>`<option value="${esc(c.name)}">${esc(c.name)}</option>`).join('');populateCalendarMonths('teamCalendarMonth');populateCalendarMonths('clientCalendarMonth')}
function populateCalendarMonths(id){const s=document.getElementById(id);if(!s)return;const now=new Date();let html='';for(let offset=-3;offset<=9;offset++){const d=new Date(now.getFullYear(),now.getMonth()+offset,1);const value=d.getFullYear()+'-'+String(d.getMonth()+1).padStart(2,'0');html+=`<option value="${value}">${d.toLocaleString('en-US',{month:'long',year:'numeric'})}</option>`}s.innerHTML=html;s.value=now.getFullYear()+'-'+String(now.getMonth()+1).padStart(2,'0')}
function buildCalendar(monthValue,filters,type){const box=document.getElementById(type==='team'?'teamCalendarGrid':'clientCalendarGrid');if(!box)return;const [year,month]=monthValue.split('-').map(Number);const first=new Date(year,month-1,1),days=new Date(year,month,0).getDate(),start=(first.getDay()+6)%7;let html='';for(let i=0;i<start;i++)html+='<div class="day"><b></b></div>';for(let day=1;day<=days;day++){const date=year+'-'+String(month).padStart(2,'0')+'-'+String(day).padStart(2,'0'),today=new Date().toISOString().slice(0,10);const events=CALENDAR_EVENTS.filter(e=>e.date===date&&e.type===type&&(!filters.person||filters.person==='all'||e.member===filters.person)&&(!filters.client||filters.client==='all'||e.client===filters.client)&&(!filters.platform||filters.platform==='all'||e.platform===filters.platform));html+=`<div class="day ${date===today?'today':''}"><b>${new Date(date+'T00:00:00').toLocaleString('en-US',{weekday:'short'})} ${day}</b>${events.map(e=>`<a href="#" class="event" onclick="openTaskDetail('${e.id}');return false" style="display:block;text-decoration:none"><b>${esc(e.title)}</b><br>${esc(e.time)}<br><small>${esc(e.member)} · ${esc(e.platform)}</small></a>`).join('')}</div>`}box.innerHTML=html}
function searchTeamCalendar(){const month=val('teamCalendarMonth');if(month)buildCalendar(month,{person:val('teamCalendarMember'),platform:val('teamCalendarPlatform')},'team')}
function searchClientCalendar(){const month=val('clientCalendarMonth');if(month)buildCalendar(month,{client:val('clientCalendarClient'),platform:val('clientCalendarPlatform')},'client')}
function openTaskDetail(id){localStorage.setItem('tt_task_preview',id);go('taskDetail')}
function renderTaskDetail(id){const box=document.getElementById('taskDetailContent');if(!box)return;const saved=JSON.parse(localStorage.getItem('tt_tasks')||'[]');const demo=CALENDAR_EVENTS.find(e=>e.id===id);const task=saved.find(t=>t.id===id)||demo;if(!task){box.innerHTML='<div class="notice">Task not found.</div>';return}document.getElementById('taskDetailSubtitle').textContent=(task.title||'Task')+' · '+(task.client||'');box.innerHTML=`<div class="task-detail-grid"><div class="task-detail-card"><span>Task</span><b>${esc(task.title||'—')}</b></div><div class="task-detail-card"><span>Client</span><b>${esc(task.client||'—')}</b></div><div class="task-detail-card"><span>Platform</span><b>${esc(task.platform||'—')}</b></div><div class="task-detail-card"><span>Assigned</span><b>${esc(task.member||task.assigned||'—')}</b></div><div class="task-detail-card"><span>Due</span><b>${esc(task.due||task.date||'—')}</b></div><div class="task-detail-card"><span>Publish</span><b>${esc(task.publish||task.time||'—')}</b></div><div class="task-detail-card"><span>Status</span><b>${esc(task.status||'Planned')}</b></div><div class="task-detail-card"><span>Approval</span><b>${esc(task.approvals||'Team review')}</b></div></div><div class="panel" style="padding:0;box-shadow:none"><table class="table"><tr><th>Task Notes</th><td>${esc(task.notes||'Calendar task details and delivery requirements.')}</td></tr><tr><th>Work Proof</th><td>${task.proof||task.work_url?`<a href="${esc(task.proof||task.work_url)}" target="_blank">Open Work Proof</a>`:'Not attached yet'}</td></tr><tr><th>Attachment / Work Link</th><td>${task.attachmentLink?`<a href="${esc(task.attachmentLink)}" target="_blank">Open Attachment</a>`:'—'}</td></tr></table></div><div class="quick"><button class="btn" onclick="go('tasks')">Open Tasks Page</button><button class="btn secondary" onclick="goBack()">← Back</button></div>`}

function downloadTemplate(){const csv='date,time,client,platform,content_type,title,assigned_to,approval_chain,status,work_url\n2026-10-01,11:00,Client A,Instagram,Poster,October Launch,Ravi,@TeamLead|@ClientA,Planned,';const a=document.createElement('a');a.href='data:text/csv;charset=utf-8,'+encodeURIComponent(csv);a.download='tasktracker_monthly_calendar_template.csv';a.click();toast('CSV template downloaded')}
function searchTasks(){
 const q=(document.getElementById('taskSearchInput')?.value||'').trim().toLowerCase();
 const member=document.getElementById('taskMemberFilter')?.value||'';
 const platform=document.getElementById('taskPlatformFilter')?.value||'';
 const status=document.getElementById('taskStatusFilter')?.value||'';
 const rows=[...document.querySelectorAll('#taskListTable [data-task-row]')];
 let shown=0;
 rows.forEach(row=>{
   const text=row.textContent.toLowerCase();
   const ok=(!q||text.includes(q))&&(!member||row.dataset.member===member)&&(!platform||row.dataset.platform===platform)&&(!status||row.dataset.status===status);
   row.style.display=ok?'':'none'; if(ok)shown++;
 });
 toast(shown+' task'+(shown===1?'':'s')+' found');
}

function loadClientsPage(){go('clients');loadClients()}
function loadMembersPage(){go('team');loadMembers()}

function populateTaskMemberFilter(){
 const select=document.getElementById('taskMemberFilter');
 if(!select)return;
 const current=select.value;
 select.innerHTML='<option value="">All Members</option>'+getMembers().map(m=>`<option value="${esc(m.name)}">${esc(m.name)}</option>`).join('');
 if(current)select.value=current;
}
function populateTaskCreateMembers(){
 const select=document.getElementById('taskMember');
 if(!select)return;
 const current=select.value;
 select.innerHTML=getMembers().map(m=>`<option value="${esc(m.name)}">${esc(m.name)}</option>`).join('');
 if(current)select.value=current;
}

function populateClientFilter(){
 const select=document.getElementById('clientFilterSelect');if(!select)return;const current=select.value;
 select.innerHTML='<option value="">Clients</option>'+getClients().map(c=>`<option value="${esc(c.id)}">${esc(c.name)}</option>`).join('');if(current)select.value=current;
}
function populateMemberFilter(){
 const select=document.getElementById('memberFilterSelect');if(!select)return;const current=select.value;
 select.innerHTML='<option value="">Members</option>'+getMembers().map(m=>`<option value="${esc(m.id)}">${esc(m.name)}</option>`).join('');if(current)select.value=current;
}
function loadClients(){
 const body=document.getElementById('clientsTableBody');if(!body)return;const clients=getClients();populateClientFilter();
 body.innerHTML=clients.length?clients.map(c=>`<tr><td><b>${esc(c.name)}</b><br><small>${esc(c.company_name||c.contact_person||'')}</small><br><small>${esc(c.email||'')}</small></td><td><span class="badge">${esc(c.work_model||'End-to-End Owner')}</span></td><td>${esc(c.owner||'—')}</td><td>${esc(c.platforms||'—')}</td><td>${esc(c.monthly_deliverables||'—')}</td><td><button class="btn secondary" onclick="previewClient('${esc(c.id)}')">View</button></td><td><span class="badge ok">${esc(c.status)}</span></td></tr>`).join(''):'<tr><td colspan="7">No clients added yet.</td></tr>';
}
function loadMembers(){
 const body=document.getElementById('membersTableBody');if(!body)return;const members=getMembers();populateMemberFilter();
 body.innerHTML=members.length?members.map(m=>`<tr><td><b>${esc(m.name)}</b><br><small>${esc(m.email)}</small></td><td>${esc(m.role)}</td><td>${esc(m.skills||m.field||'—')}</td><td>${esc(m.notes||'—')}</td><td>—</td><td>—</td><td><div class="progress"><i style="width:0%"></i></div>New</td><td><button class="btn secondary" onclick="previewMember('${esc(m.id)}')">View</button></td></tr>`).join(''):'<tr><td colspan="8">No members added yet.</td></tr>';
}
function loadClientReportList(){
 const box=document.getElementById('clientReportList');if(!box)return;
 box.innerHTML=getClients().map(c=>`<div class="report-client-card"><h3>${esc(c.name)}</h3><p><b>Company:</b> ${esc(c.company_name||'—')}</p><p><b>Platforms:</b> ${esc(c.platforms||'—')}</p><p><b>Monthly work:</b> ${esc(c.monthly_deliverables||'—')}</p><p><b>Status:</b> ${esc(c.status||'—')}</p><div class="report-actions"><button class="btn" onclick="previewClient('${esc(c.id)}')">Open Report</button><button class="btn secondary" onclick="openClientPortalFor('${esc(c.id)}')">Client Portal</button></div></div>`).join('')||'<div class="notice">No clients available.</div>';
}
function openClientPortalFor(id){localStorage.setItem('tt_client_preview',id);go('clientportal')}
function previewClient(id){localStorage.setItem('tt_client_preview',id);go('clientReport')}
function previewMember(id){localStorage.setItem('tt_member_preview',id);go('memberReport')}
function searchClientReport(){const id=document.getElementById('clientFilterSelect')?.value||'';const status=document.getElementById('clientStatusFilter')?.value||'';const c=getClients().find(x=>(!id||x.id===id)&&(!status||x.status===status));if(!c){toast('Select a matching client and status');return}previewClient(c.id)}
function searchMemberReport(){const id=document.getElementById('memberFilterSelect')?.value||'';const status=document.getElementById('memberStatusFilter')?.value||'';const m=getMembers().find(x=>(!id||x.id===id)&&(!status||x.status===status));if(!m){toast('Select a matching member and status');return}previewMember(m.id)}
function renderClientReport(id){
 const c=getClients().find(x=>x.id===id),box=document.getElementById('clientReportContent'),sub=document.getElementById('clientReportSubtitle');if(!box)return;if(!c){box.innerHTML='<div class="notice">Client not found.</div>';return}
 if(sub)sub.textContent=(c.name||'Client')+' · Individual client report';
 box.innerHTML=`<div class="kpis"><div class="kpi">Status<b>${esc(c.status||'—')}</b></div><div class="kpi">Monthly Deliverables<b>${esc(c.monthly_deliverables||'—')}</b></div><div class="kpi">Platforms<b>${esc(c.platforms||'—')}</b></div><div class="kpi">Assigned Member<b>${esc(c.owner||'—')}</b></div></div><div class="panel" style="margin-top:14px;padding:0;box-shadow:none"><table class="table"><tr><th>Company Name</th><td>${esc(c.company_name||'—')}</td></tr><tr><th>Client Name</th><td>${esc(c.name||'—')}</td></tr><tr><th>Contact No</th><td>${esc(c.contact_no||c.phone||'—')}</td></tr><tr><th>Email ID</th><td>${esc(c.email||'—')}</td></tr><tr><th>Website</th><td>${esc(c.website||'—')}</td></tr><tr><th>WhatsApp No</th><td>${esc(c.whatsapp_no||'—')}</td></tr><tr><th>Platforms</th><td>${esc(c.platforms||'—')}</td></tr><tr><th>Monthly Deliverables</th><td>${esc(c.monthly_deliverables||'—')}</td></tr><tr><th>Assigned Member</th><td>${esc(c.owner||'—')}</td></tr><tr><th>Notes</th><td>${esc(c.notes||'—')}</td></tr></table></div><div class="quick"><button class="btn secondary" onclick="goBack()">← Back</button><button class="btn success" onclick="go('clientportal')">Open Client Portal</button></div>`;
}
function renderMemberReport(id){
 const m=getMembers().find(x=>x.id===id),box=document.getElementById('memberReportContent'),sub=document.getElementById('memberReportSubtitle');if(!box)return;if(!m){box.innerHTML='<div class="notice">Team member not found.</div>';return}
 if(sub)sub.textContent=(m.name||'Member')+' · Individual work and performance report';
 box.innerHTML=`<div class="kpis"><div class="kpi">Role<b>${esc(m.role||'—')}</b></div><div class="kpi">Field<b>${esc(m.field||'—')}</b></div><div class="kpi">Platforms<b>${esc(m.skills||'—')}</b></div><div class="kpi">Status<b>${esc(m.status||'—')}</b></div></div><div class="panel" style="margin-top:14px;padding:0;box-shadow:none"><table class="table"><tr><th>Full Name</th><td>${esc(m.name||'—')}</td></tr><tr><th>Phone No</th><td>${esc(m.phone||'—')}</td></tr><tr><th>WhatsApp No</th><td>${esc(m.whatsapp||'—')}</td></tr><tr><th>Login Email</th><td>${esc(m.email||'—')}</td></tr><tr><th>Role</th><td>${esc(m.role||'—')}</td></tr><tr><th>Status</th><td>${esc(m.status||'—')}</td></tr><tr><th>Primary Field / Expertise</th><td>${esc(m.field||'—')}</td></tr><tr><th>Platform Skills</th><td>${esc(m.skills||'—')}</td></tr><tr><th>Notes</th><td>${esc(m.notes||'—')}</td></tr></table></div><div class="panel" style="padding:0;box-shadow:none"><div class="head"><h3 style="margin:0">Work Report</h3></div><div class="kpis"><div class="kpi">Today<b>—</b></div><div class="kpi">This Week<b>—</b></div><div class="kpi">This Month<b>—</b></div><div class="kpi">This Year<b>—</b></div></div><p style="font-size:12px;color:#64748b;margin-top:12px">Work counts, completed tasks, proof URLs and client assignments will populate here after the database is connected.</p></div><div class="quick"><button class="btn secondary" onclick="go('team')">← Back to Team Members</button></div>`;
}
const CAMPAIGN_HISTORY=[
 {id:'ca1',date:'2026-09-28',client:'Client B',platform:'Meta Ads',type:'Campaign',title:'September Lead Generation',schedule:'Sep 28 · 4 PM',status:'Ready',objective:'Generate qualified leads from the September offer.'},
 {id:'ca2',date:'2026-09-24',client:'Client A',platform:'Instagram',type:'Posts + Reels',title:'September Product Push',schedule:'Sep 24 · 11 AM',status:'Active',objective:'Increase product visibility and engagement.'},
 {id:'ca3',date:'2026-08-18',client:'Client C',platform:'YouTube',type:'Video',title:'August Brand Video',schedule:'Aug 18 · 6 PM',status:'Completed',objective:'Publish a brand awareness video.'},
 {id:'ca4',date:'2026-07-12',client:'Client A',platform:'Instagram',type:'Reels',title:'July Reel Campaign',schedule:'Jul 12 · 11 AM',status:'Completed',objective:'Drive profile visits through short-form video.'}
];
const CLIENT_CONNECTIONS={
 'c1':[
  {platform:'Meta / Instagram',account:'Client A Instagram',status:'Connected',connectedOn:'2026-08-05',actions:'Schedule · Publish · Insights'},
  {platform:'Google Ads',account:'Client A Ads',status:'Connected',connectedOn:'2026-08-10',actions:'Campaign sync · Reporting'},
  {platform:'YouTube',account:'Client A YouTube',status:'OAuth required',connectedOn:'—',actions:'Schedule · Analytics'},
  {platform:'WhatsApp Business',account:'Client A WhatsApp',status:'API setup',connectedOn:'—',actions:'Campaign send · Reports'}
 ],
 'c2':[
  {platform:'Meta / Instagram',account:'Client B Instagram',status:'Connected',connectedOn:'2026-08-07',actions:'Schedule · Publish · Insights'},
  {platform:'Google Ads',account:'Client B Ads',status:'Connected',connectedOn:'2026-08-11',actions:'Campaign sync · Reporting'},
  {platform:'YouTube',account:'Client B YouTube',status:'Connected',connectedOn:'2026-08-15',actions:'Schedule · Analytics'},
  {platform:'WhatsApp Business',account:'Client B WhatsApp',status:'API setup',connectedOn:'—',actions:'Campaign send · Reports'}
 ],
 'c3':[
  {platform:'Meta / Instagram',account:'Client C Instagram',status:'Connected',connectedOn:'2026-08-03',actions:'Schedule · Publish · Insights'},
  {platform:'Google Ads',account:'Client C Ads',status:'Not connected',connectedOn:'—',actions:'Campaign sync · Reporting'},
  {platform:'YouTube',account:'Client C YouTube',status:'OAuth required',connectedOn:'—',actions:'Schedule · Analytics'},
  {platform:'WhatsApp Business',account:'Client C WhatsApp',status:'Connected',connectedOn:'2026-08-19',actions:'Campaign send · Reports'}
 ]
};
const MEETING_HISTORY=[
 {id:'m1',date:'2026-09-25',time:'11:00 AM',title:'Monthly Content Review',client:'Client A',participants:'Ravi, Priya, Client A',agenda:'Review September content performance and approve upcoming posts.',notes:'Client approved the next content batch.',followups:'Ravi to upload final creatives; client to share October offers.',status:'Completed'},
 {id:'m2',date:'2026-09-26',time:'3:00 PM',title:'Ads Performance Review',client:'Client B',participants:'Neha, Priya, Client B',agenda:'Review Meta Ads leads, spend and conversion performance.',notes:'Budget and creative revisions discussed.',followups:'Neha to prepare revised ad set; Priya to review report.',status:'Completed'},
 {id:'m3',date:'2026-08-22',time:'12:00 PM',title:'August Monthly Review',client:'Client C',participants:'Arjun, Priya, Client C',agenda:'Monthly delivery and YouTube performance review.',notes:'Video topics for September shortlisted.',followups:'Arjun to prepare September video plan.',status:'Completed'},
 {id:'m4',date:'2026-07-29',time:'4:00 PM',title:'Quarterly Growth Discussion',client:'Client A',participants:'Ravi, Priya, Client A',agenda:'Discuss quarterly growth metrics and campaign priorities.',notes:'New campaign themes discussed.',followups:'Team to prepare campaign concepts.',status:'Completed'}
];

function searchWorkRates(){
 const period=document.getElementById('workRatePeriod')?.value||'monthly',month=document.getElementById('workRateMonth')?.value||'2026-09';
 const labels={daily:'Daily Report',weekly:'Weekly Report',monthly:'Monthly Report',yearly:'Yearly Report'};
 const counts={daily:['19','—','—','—'],weekly:['19','96','—','—'],monthly:['19','96','382','—'],yearly:['19','96','382','3,846']}[period]||['19','96','382','3,846'];
 const box=document.getElementById('workRateReport');if(!box)return;
 box.innerHTML=`<div class="notice"><b>${labels[period]}</b> · ${esc(month)}</div><div class="kpis"><div class="kpi">Daily completed<b>${counts[0]}</b></div><div class="kpi">Weekly completed<b>${counts[1]}</b></div><div class="kpi">Monthly completed<b>${counts[2]}</b></div><div class="kpi">Yearly completed<b>${counts[3]}</b></div></div><h3 style="font-size:14px;margin-top:20px">Team Member Output</h3><table class="table"><tr><th>Member</th><th>Today</th><th>This Week</th><th>This Month</th><th>This Year</th><th>Proof attached</th></tr><tr><td>Ravi</td><td>6</td><td>27</td><td>108</td><td>1,046</td><td>98%</td></tr><tr><td>Neha</td><td>5</td><td>21</td><td>89</td><td>932</td><td>96%</td></tr><tr><td>Arjun</td><td>4</td><td>19</td><td>76</td><td>814</td><td>100%</td></tr></table>`;
 toast(labels[period]+' loaded');
}

function openCampaignSearch(){const e=document.getElementById('campaignSearchBar');if(e)e.style.display='flex';document.getElementById('campaignSearchInput')?.focus();}
function closeCampaignSearch(){const e=document.getElementById('campaignSearchBar');if(e)e.style.display='none';}
function searchCampaigns(){
 const q=(document.getElementById('campaignSearchInput')?.value||'').toLowerCase().trim();
 const rows=CAMPAIGN_HISTORY.filter(c=>!q||Object.values(c).some(v=>String(v).toLowerCase().includes(q)));
 const table=document.getElementById('campaignCurrentTable');if(!table)return;
 table.innerHTML='<tr><th>Date</th><th>Client</th><th>Platform</th><th>Campaign</th><th>Status</th><th>View</th></tr>'+rows.map(c=>`<tr><td>${esc(c.date)}</td><td>${esc(c.client)}</td><td>${esc(c.platform)}</td><td>${esc(c.title)}</td><td><span class="badge ${c.status==='Completed'?'ok':''}">${esc(c.status)}</span></td><td><button class="btn secondary" onclick="openCampaignDetail('${c.id}')">View</button></td></tr>`).join('')||'<tr><td colspan="6">No campaigns found.</td></tr>';
}
function showCampaignHistory(mode='monthly'){const sel=document.getElementById('campaignHistoryMode');if(sel)sel.value=mode;renderCampaignHistory();}
function renderCampaignHistory(){searchCampaignHistory();}
function searchCampaignHistory(){
 const mode=document.getElementById('campaignHistoryMode')?.value||'monthly',month=document.getElementById('campaignMonthSelect')?.value||'2026-09',q=(document.getElementById('campaignHistorySearch')?.value||'').toLowerCase().trim();
 const rows=CAMPAIGN_HISTORY.filter(c=>(mode==='old'||c.date.startsWith(month))&&(!q||Object.values(c).some(v=>String(v).toLowerCase().includes(q))));
 const box=document.getElementById('campaignHistoryResults');if(!box)return;
 box.innerHTML=`<table class="table"><tr><th>Date</th><th>Client</th><th>Platform</th><th>Campaign</th><th>Type</th><th>Status</th><th>View</th></tr>${rows.map(c=>`<tr><td>${esc(c.date)}</td><td>${esc(c.client)}</td><td>${esc(c.platform)}</td><td>${esc(c.title)}</td><td>${esc(c.type)}</td><td><span class="badge ${c.status==='Completed'?'ok':''}">${esc(c.status)}</span></td><td><button class="btn secondary" onclick="openCampaignDetail('${c.id}')">View</button></td></tr>`).join('')||'<tr><td colspan="7">No campaign records found.</td></tr>'}</table>`;
}
function openCampaignDetail(id){localStorage.setItem('tt_campaign_preview',id);go('campaignDetail');}
function renderCampaignDetail(id){const c=CAMPAIGN_HISTORY.find(x=>x.id===id),box=document.getElementById('campaignDetailContent');if(!box)return;if(!c){box.innerHTML='<div class="notice">Campaign not found.</div>';return}document.getElementById('campaignDetailSubtitle').textContent=c.title+' · '+c.client;box.innerHTML=`<div class="kpis"><div class="kpi">Client<b>${esc(c.client)}</b></div><div class="kpi">Platform<b>${esc(c.platform)}</b></div><div class="kpi">Type<b>${esc(c.type)}</b></div><div class="kpi">Status<b>${esc(c.status)}</b></div></div><div class="panel" style="margin-top:14px;padding:0;box-shadow:none"><table class="table"><tr><th>Campaign</th><td>${esc(c.title)}</td></tr><tr><th>Date</th><td>${esc(c.date)}</td></tr><tr><th>Schedule</th><td>${esc(c.schedule)}</td></tr><tr><th>Objective</th><td>${esc(c.objective)}</td></tr></table></div>`;}

function populateGrowthClients(){const s=document.getElementById('growthClientSelect');if(!s)return;const cur=s.value;s.innerHTML='<option value="">Select Client</option>'+getClients().map(c=>`<option value="${esc(c.id)}">${esc(c.name)}</option>`).join('');if(cur)s.value=cur;}
function searchClientGrowth(){const id=document.getElementById('growthClientSelect')?.value||'';if(!id){toast('Select a client first');return}const c=getClients().find(x=>x.id===id);if(!c)return;const base={c1:['48.6K','186','3,920','12.8K'],c2:['42.1K','164','3,410','10.9K'],c3:['35.7K','121','2,880','9.6K']}[id]||['48.6K','186','3,920','12.8K'];['growthViews','growthLeads','growthLikes','growthFollowers'].forEach((x,i)=>{const e=document.getElementById(x);if(e)e.textContent=base[i]});document.getElementById('growthTimeline').innerHTML=`<div class="item"><b>Latest platform milestone — ${esc(c.name)}</b><br>${esc(base[0])} views, ${esc(base[1])} leads and ${esc(base[2])} likes in the selected client report.</div><div class="item"><b>Monthly review</b><br>Compare content, campaigns and engagement against the previous month.</div><div class="item"><b>Delivery baseline</b><br>${esc(c.monthly_deliverables||'Monthly deliverables recorded for this client.')}</div>`;toast('Client growth report loaded');}

function populateIntegrationClients(){const s=document.getElementById('integrationClientSelect');if(!s)return;const cur=s.value;s.innerHTML='<option value="">Select Client</option>'+getClients().map(c=>`<option value="${esc(c.id)}">${esc(c.name)}</option>`).join('');if(cur)s.value=cur;}
function searchClientIntegrations(){const id=document.getElementById('integrationClientSelect')?.value||'';if(!id){toast('Select a client first');return}localStorage.setItem('tt_integration_client',id);go('integrationClientReport');}
function renderIntegrationClientReport(id){const c=getClients().find(x=>x.id===id),box=document.getElementById('integrationClientContent');if(!box)return;if(!c){box.innerHTML='<div class="notice">Client not found.</div>';return}const rows=CLIENT_CONNECTIONS[id]||[];document.getElementById('integrationClientSubtitle').textContent=c.name+' · platform connection details';box.innerHTML=`<div class="kpis"><div class="kpi">Client<b>${esc(c.name)}</b></div><div class="kpi">Platforms<b>${esc(c.platforms||'—')}</b></div><div class="kpi">Connected<b>${rows.filter(r=>r.status==='Connected').length}</b></div><div class="kpi">Needs Setup<b>${rows.filter(r=>r.status!=='Connected').length}</b></div></div><table class="table"><tr><th>Platform</th><th>Client Account</th><th>Status</th><th>Connected On</th><th>Available Actions</th></tr>${rows.map(r=>`<tr><td>${esc(r.platform)}</td><td>${esc(r.account)}</td><td><span class="badge ${r.status==='Connected'?'ok':'warn'}">${esc(r.status)}</span></td><td>${esc(r.connectedOn)}</td><td>${esc(r.actions)}</td></tr>`).join('')}</table>`;}

function openMeetingSearch(){const e=document.getElementById('meetingSearchBar');if(e)e.style.display='flex';document.getElementById('meetingSearchInput')?.focus();}
function closeMeetingSearch(){const e=document.getElementById('meetingSearchBar');if(e)e.style.display='none';}
function searchMeetings(){const q=(document.getElementById('meetingSearchInput')?.value||'').toLowerCase().trim();const rows=MEETING_HISTORY.filter(m=>!q||Object.values(m).some(v=>String(v).toLowerCase().includes(q)));const box=document.getElementById('meetingSearchResults');if(!box)return;box.innerHTML=`<table class="table"><tr><th>Date</th><th>Meeting</th><th>Client</th><th>Participants</th><th>View</th></tr>${rows.map(m=>`<tr><td>${esc(m.date)} · ${esc(m.time)}</td><td>${esc(m.title)}</td><td>${esc(m.client)}</td><td>${esc(m.participants)}</td><td><button class="btn secondary" onclick="openMeetingDetail('${m.id}')">View</button></td></tr>`).join('')||'<tr><td colspan="5">No meetings found.</td></tr>'}</table>`;}
function showMeetingHistory(mode='monthly'){const s=document.getElementById('meetingHistoryMode');if(s)s.value=mode;renderMeetingHistory();}
function renderMeetingHistory(){searchMeetingHistory();}
function searchMeetingHistory(){const mode=document.getElementById('meetingHistoryMode')?.value||'monthly',month=document.getElementById('meetingMonthSelect')?.value||'2026-09',date=document.getElementById('meetingDateSelect')?.value||'',q=(document.getElementById('meetingHistorySearch')?.value||'').toLowerCase().trim();let rows=MEETING_HISTORY.filter(m=>(mode==='date'?(date?m.date===date:true):m.date.startsWith(month))&&(!q||Object.values(m).some(v=>String(v).toLowerCase().includes(q))));const box=document.getElementById('meetingHistoryResults');if(!box)return;box.innerHTML=`<table class="table"><tr><th>Date</th><th>Meeting</th><th>Client</th><th>Participants</th><th>Status</th><th>View</th></tr>${rows.map(m=>`<tr><td>${esc(m.date)} · ${esc(m.time)}</td><td>${esc(m.title)}</td><td>${esc(m.client)}</td><td>${esc(m.participants)}</td><td><span class="badge ok">${esc(m.status)}</span></td><td><button class="btn secondary" onclick="openMeetingDetail('${m.id}')">View</button></td></tr>`).join('')||'<tr><td colspan="6">No meeting records found.</td></tr>'}</table>`;}
function openMeetingDetail(id){localStorage.setItem('tt_meeting_preview',id);go('meetingDetail');}
function renderMeetingDetail(id){const m=MEETING_HISTORY.find(x=>x.id===id),box=document.getElementById('meetingDetailContent');if(!box)return;if(!m){box.innerHTML='<div class="notice">Meeting not found.</div>';return}document.getElementById('meetingDetailSubtitle').textContent=m.title+' · '+m.client;box.innerHTML=`<div class="kpis"><div class="kpi">Date<b>${esc(m.date)}</b></div><div class="kpi">Time<b>${esc(m.time)}</b></div><div class="kpi">Client<b>${esc(m.client)}</b></div><div class="kpi">Status<b>${esc(m.status)}</b></div></div><table class="table"><tr><th>Meeting</th><td>${esc(m.title)}</td></tr><tr><th>Participants</th><td>${esc(m.participants)}</td></tr><tr><th>Agenda</th><td>${esc(m.agenda)}</td></tr><tr><th>Notes</th><td>${esc(m.notes)}</td></tr><tr><th>Follow-ups</th><td>${esc(m.followups)}</td></tr></table>`;}

function renderAllClientReports(){
 const box=document.getElementById('allClientReportsList');if(!box)return;
 const u=effectiveUser();
 let clients=getClients();
 if(u?.role==='client') clients=clients.filter(c=>c.email===u.email);
 box.innerHTML=clients.map(c=>`<div class="report-client-card"><h3>${esc(c.name)}</h3><p><b>Company:</b> ${esc(c.company_name||'—')}</p><p><b>Platforms:</b> ${esc(c.platforms||'—')}</p><p><b>Monthly work:</b> ${esc(c.monthly_deliverables||'—')}</p><p><b>Owner:</b> ${esc(c.owner||'—')}</p><p><b>Status:</b> ${esc(c.status||'—')}</p><div class="report-actions"><button class="btn" onclick="previewClient('${esc(c.id)}')">Open Report</button></div></div>`).join('')||'<div class="notice">No client report available.</div>';
}

function renderPortalUsers(){
 const grid=document.getElementById('portalUserGrid');if(!grid)return;
 if(!isManagerOrLeader()){grid.innerHTML='<div class="notice">Only Managers and Team Leaders can open other user portals.</div>';return;}
 const me=currentUser(),view=currentView(),users=getUsers();
 grid.innerHTML=users.map(u=>`<div class="portal-user-card ${view?.id===u.id?'current':''}"><div class="portal-user-top"><div><h3>${esc(u.name)}</h3><p>${esc(u.roleLabel||u.role)}</p><p>${esc(u.email)}</p><p><b>Field:</b> ${esc(u.field||'—')}</p><p><b>Client:</b> ${esc(u.client||'—')}</p></div><span class="badge ${u.role==='client'?'ok':''}">${esc(u.roleLabel||u.role)}</span></div><div class="portal-user-actions"><button class="btn ${view?.id===u.id?'secondary':''}" onclick="switchUserPortal('${esc(u.id)}')">${view?.id===u.id?'Current View':'Open Portal'}</button></div></div>`).join('');
}
function openRoleSwitcher(){if(!isManagerOrLeader()){toast('Only Managers and Team Leaders can switch portal views');return}openModal('roleModal')}
function switchUserPortal(id){if(!isManagerOrLeader()){toast('Only Managers and Team Leaders can switch portal views');return}const u=getUsers().find(x=>x.id===id);if(!u)return;localStorage.setItem('tt_view_as',u.id);closeModal('roleModal');applyRoleRestrictions();updateUserHeader();toast('Now viewing '+u.name+' — '+u.roleLabel);go(u.role==='client'?'clientportal':'dashboard')}
function backToMyView(){localStorage.removeItem('tt_view_as');closeModal('roleModal');applyRoleRestrictions();updateUserHeader();go('dashboard');toast('Returned to your normal view')}

function saveClient(){
 if(!isManagerOrLeader()){toast('Only Managers and Team Leaders can add clients');return}
 const payload={id:'c'+Date.now(),company_name:val('clientCompanyName'),name:val('clientName'),contact_no:val('clientContactNo'),email:val('clientEmail'),password:'Client@123',phone:val('clientContactNo'),whatsapp_no:val('clientWhatsapp'),work_model:'End-to-End Owner',status:val('clientStatus'),platforms:val('clientPlatforms'),website:val('clientWebsite'),monthly_deliverables:val('clientDeliverables'),owner:val('clientOwner'),notes:val('clientNotes')};
 if(!payload.company_name||!payload.name||!payload.email){toast('Company name, client name and email ID are required');return}
 const clients=getClients();clients.push(payload);setClients(clients);
 const users=JSON.parse(localStorage.getItem('tt_users')||'[]');users.push({id:'cu'+Date.now(),name:payload.name,email:payload.email,password:payload.password,role:'client',roleLabel:'Client',field:'Client Portal',client:payload.company_name});localStorage.setItem('tt_users',JSON.stringify(users));
 closeModal('clientModal');loadClients();resetForm(['clientCompanyName','clientName','clientContactNo','clientEmail','clientWebsite','clientWhatsapp','clientPlatforms','clientDeliverables','clientOwner','clientNotes']);toast('Client added to front-end demo data')
}
function saveMember(){
 if(!isManagerOrLeader()){toast('Only Managers and Team Leaders can add members');return}
 const payload={id:'m'+Date.now(),name:val('memberName'),email:val('memberEmail'),password:'Member@123',phone:val('memberPhone'),whatsapp:val('memberWhatsapp'),role:val('memberRole'),field:val('memberField'),skills:val('memberSkills'),work_model:'Platform Expert',status:val('memberStatus'),notes:val('memberNotes')};
 if(!payload.name||!payload.email){toast('Full name and login email are required');return}
 const members=getMembers();members.push(payload);setMembers(members);
 const users=JSON.parse(localStorage.getItem('tt_users')||'[]');const roleMap={'Team Member':'team_member','Team Leader':'team_leader','Manager':'manager'};users.push({id:'mu'+Date.now(),name:payload.name,email:payload.email,password:payload.password,role:roleMap[payload.role]||'team_member',roleLabel:payload.role,field:payload.field,client:payload.notes||'Assigned clients'});localStorage.setItem('tt_users',JSON.stringify(users));
 closeModal('teamModal');loadMembers();resetForm(['memberName','memberPhone','memberEmail','memberWhatsapp','memberField','memberSkills','memberNotes']);toast('Team member added to front-end demo data')
}
function resetForm(ids){ids.forEach(id=>{const e=document.getElementById(id);if(e)e.value=''})}

function updateUserHeader(){
 const me=currentUser(),view=currentView(),u=view||me;if(!u)return;
 document.body.classList.toggle('impersonating',!!view);
 const n=document.getElementById('currentUserName');const r=document.getElementById('currentUserRole');if(n)n.textContent=u.name;if(r)r.textContent=u.roleLabel||u.role;
 const mobileName=document.querySelector('.mobile-menu-profile strong');const mobileSub=document.querySelector('.mobile-menu-profile small');const mobileInitial=document.querySelector('.mobile-profile-large');const topInitial=document.querySelector('.mobile-profile-btn');
 if(mobileName)mobileName.textContent=u.name;if(mobileSub)mobileSub.textContent=u.roleLabel||u.role;if(mobileInitial)mobileInitial.textContent=(u.name||'U').slice(0,2).toUpperCase();if(topInitial)topInitial.textContent=(u.name||'U').slice(0,2).toUpperCase();
 const banner=document.getElementById('viewBannerText');if(banner)banner.textContent=view?u.name+' · '+u.roleLabel:'Normal view';
}
function applyRoleRestrictions(){
 const u=effectiveUser();if(!u)return;
 const managerLike=['manager','team_leader'].includes(u.role);
 document.querySelectorAll('.switch-only-manager').forEach(b=>b.style.display=managerLike?'inline-flex':'none');
 document.querySelectorAll('.manager-only-section').forEach(el=>el.style.display=managerLike?'block':'none');
 if(u.role==='client'){
   document.querySelectorAll('.page').forEach(p=>p.classList.remove('active'));document.getElementById('clientportal')?.classList.add('active');
   document.querySelectorAll('.nav button').forEach(b=>b.style.display='none');
   const t=document.getElementById('title');if(t)t.textContent='Client Reports';
 }else if(u.role==='team_member'){
   document.querySelectorAll('.nav button').forEach(b=>b.style.display='');
   ['clients','team','workload','bulk','performance','campaigns','milestones','integrations'].forEach(id=>{document.querySelector(`.nav button[onclick*="'${id}'"]`)?.style.setProperty('display','none');document.querySelector(`.mobile-drawer-item[data-page="${id}"]`)?.style.setProperty('display','none');});
   ['dashboard','tasks','calendar','attendance','approvals','meetings','notifications'].forEach(id=>{document.querySelector(`.mobile-drawer-item[data-page="${id}"]`)?.style.setProperty('display','flex');});
 }
}

function attemptLogin(email,password){
 const u=getUsers().find(x=>x.email.toLowerCase()===email.toLowerCase()&&x.password===password);
 if(!u)return false;
 localStorage.setItem('tt_current_user',u.id);localStorage.removeItem('tt_view_as');return true;
}
function startApp(){
 document.getElementById('authScreen').classList.add('app-hidden');document.getElementById('appShell').classList.remove('app-hidden');
 updateUserHeader();applyRoleRestrictions();
 const u=effectiveUser();go(u?.role==='client'?'clientportal':'dashboard');
}

/* Mobile menu */
function setupMobileNav(){
 const menuBtn=document.getElementById('mobileMenuBtn'),menuClose=document.getElementById('mobileMenuClose'),overlay=document.getElementById('mobileMenuOverlay'),moreBtn=document.getElementById('mobileMoreBtn');
 const open=()=>document.body.classList.add('mobile-menu-open'),close=()=>document.body.classList.remove('mobile-menu-open');
 menuBtn?.addEventListener('click',open);menuClose?.addEventListener('click',close);overlay?.addEventListener('click',close);moreBtn?.addEventListener('click',open);
 document.addEventListener('keydown',e=>{if(e.key==='Escape')close()});
 document.querySelectorAll('.mobile-drawer-item[data-page]').forEach(item=>item.addEventListener('click',e=>{e.preventDefault();go(item.dataset.page);close()}));
 document.querySelectorAll('.mobile-bottom-item[data-page]').forEach(item=>item.addEventListener('click',e=>{e.preventDefault();go(item.dataset.page)}));
 document.getElementById('mobileLogoutBtn')?.addEventListener('click',()=>{close();logout()});
}

function setupAuth(){
 const form=document.getElementById('loginForm');
 form?.addEventListener('submit',e=>{e.preventDefault();const err=document.getElementById('loginError');const ok=attemptLogin(val('loginEmail'),val('loginPassword'));if(!ok){err.textContent='Invalid email or password. Use one of the demo accounts shown below.';err.style.display='block';return}err.style.display='none';startApp()});
}

/* Close modal by clicking outside */
document.addEventListener('click',e=>{if(e.target.classList?.contains('modal'))e.target.classList.remove('open')});

document.addEventListener('DOMContentLoaded',()=>{
 getClients();getMembers();setupAuth();setupMobileNav();populateBulkMonths();populateCalendarControls();populateAttendanceMonths();populateAttendanceMembers();populateApprovalMonths();localStorage.setItem('tt_session_start',localStorage.getItem('tt_session_start')||Date.now());renderAttendanceToday();updatePunchUI();setInterval(()=>{updateAppSessionTime();updatePunchUI();},60000);
 const u=currentUser();if(u)startApp();else{document.getElementById('authScreen').classList.remove('app-hidden');document.getElementById('appShell').classList.add('app-hidden')}
 const n=document.getElementById('notifCount');if(n)n.textContent='4';
});

/* =========================================================
   DATABASE BRIDGE — PHP/MySQL
   The existing UI remains intact. This layer mirrors database
   data into localStorage for fast rendering and synchronizes
   every create/update action with api.php.
   ========================================================= */
const TT_API='api.php';
let TT_DB_READY=false;
let TT_BOOTSTRAP=null;

async function ttApi(action, payload={}, method='POST'){
  const opts={method,credentials:'same-origin',headers:{'Accept':'application/json'}};
  if(method!=='GET'){
    opts.headers['Content-Type']='application/json';
    opts.body=JSON.stringify({action,...payload});
  }
  const url=method==='GET'?TT_API+'?'+new URLSearchParams({action,...payload}).toString():TT_API;
  const res=await fetch(url,opts);
  let data={}; try{data=await res.json()}catch(e){throw new Error('Invalid server response')}
  if(!res.ok||data.ok===false) throw new Error(data.message||'Server request failed');
  return data;
}

function ttCache(name,data){try{localStorage.setItem(name,JSON.stringify(data??[]))}catch(e){}}
function ttRead(name,fallback=[]){try{const v=JSON.parse(localStorage.getItem(name)||'null');return v??fallback}catch(e){return fallback}}
function ttCurrentUserId(){return localStorage.getItem('tt_current_user')||''}

async function ttHydrate(silent=false){
  try{
    const data=await ttApi('bootstrap',{},'GET');
    TT_BOOTSTRAP=data; TT_DB_READY=true;
    ttCache('tt_clients',data.clients||[]);
    ttCache('tt_members',data.members||[]);
    ttCache('tt_users',data.users||[]);
    ttCache('tt_tasks',data.tasks||[]);
    ttCache('tt_campaigns',data.campaigns||[]);
    ttCache('tt_meetings',data.meetings||[]);
    ttCache('tt_connections',data.connections||[]);
    ttCache('tt_approvals',data.approvals||[]);
    ttCache('tt_metrics',data.metrics||[]);
    ttCache('tt_notifications',data.notifications||[]);
    return data;
  }catch(err){
    if(!silent)toast('Database connection unavailable. Running with saved browser cache.');
    return null;
  }
}

function getClients(){return ttRead('tt_clients',typeof DEFAULT_CLIENTS!=='undefined'?DEFAULT_CLIENTS:[])}
function setClients(data){ttCache('tt_clients',data)}
function getMembers(){return ttRead('tt_members',[])}
function setMembers(data){ttCache('tt_members',data)}
function getUsers(){
  const custom=ttRead('tt_users',[]);
  if(custom.length)return custom;
  return typeof DEMO_USERS!=='undefined'?DEMO_USERS:[];
}

function ttCampaigns(){return ttRead('tt_campaigns',typeof CAMPAIGN_HISTORY!=='undefined'?CAMPAIGN_HISTORY:[])}
function ttMeetings(){return ttRead('tt_meetings',typeof MEETING_HISTORY!=='undefined'?MEETING_HISTORY:[])}
function ttConnections(){return ttRead('tt_connections',{});}
function ttApprovals(){return ttRead('tt_approvals',[])}

async function attemptLogin(email,password){
  try{
    const data=await ttApi('login',{email,password});
    if(!data.user)return false;
    localStorage.setItem('tt_current_user',data.user.id);
    localStorage.removeItem('tt_view_as');
    ttCache('tt_users',data.users||[]);
    return true;
  }catch(err){
    // If XAMPP/PHP is not ready, preserve the original demo login behavior.
    const fallback=(typeof DEMO_USERS!=='undefined'?DEMO_USERS:[]).find(x=>x.email.toLowerCase()===email.toLowerCase()&&x.password===password);
    if(fallback){localStorage.setItem('tt_current_user',fallback.id);localStorage.removeItem('tt_view_as');return true}
    return false;
  }
}

async function startApp(){
  document.getElementById('authScreen').classList.add('app-hidden');
  document.getElementById('appShell').classList.remove('app-hidden');
  await ttHydrate(true);
  updateUserHeader();applyRoleRestrictions();
  const u=effectiveUser();go(u?.role==='client'?'clientportal':'dashboard');
}

function setupAuth(){
 const form=document.getElementById('loginForm');
 form?.addEventListener('submit',async e=>{
   e.preventDefault();
   const err=document.getElementById('loginError');
   err.style.display='none';
   const ok=await attemptLogin(val('loginEmail'),val('loginPassword'));
   if(!ok){err.textContent='Invalid email or password.';err.style.display='block';return}
   await startApp();
 });
}

async function saveDemoTask(){
 const title=val('taskTitle'),client=val('taskClient'),member=val('taskMember'),due=val('taskDueDate'),publish=val('taskPublishDate');
 if(!title||!client||!member||!due||!publish){toast('Please fill Task title, Client, Assigned member, Publish date and Due date');return}
 const approvals=[...document.getElementById('taskApprovers')?.selectedOptions||[]].map(o=>o.text).join(' → ');
 try{
   const data=await ttApi('create_task',{title,client,assigned:member,due,publish,type:val('taskType'),approvals,notes:val('taskNotes'),attachmentLink:val('taskAttachmentLink'),proof:val('taskProofUrl'),status:'Planned'});
   ttCache('tt_tasks',data.tasks||[]);closeModal('taskModal');toast('Task created and saved to database');
   go('tasks');
 }catch(err){toast(err.message)}
}

async function saveClient(){
 if(!isManagerOrLeader()){toast('Only Managers and Team Leaders can add clients');return}
 const payload={company_name:val('clientCompanyName'),name:val('clientName'),contact_no:val('clientContactNo'),email:val('clientEmail'),phone:val('clientContactNo'),whatsapp_no:val('clientWhatsapp'),work_model:'End-to-End Owner',status:val('clientStatus'),platforms:val('clientPlatforms'),website:val('clientWebsite'),monthly_deliverables:val('clientDeliverables'),owner:val('clientOwner'),notes:val('clientNotes')};
 if(!payload.company_name||!payload.name||!payload.email){toast('Company name, client name and email ID are required');return}
 try{const data=await ttApi('create_client',payload);ttCache('tt_clients',data.clients||[]);ttCache('tt_users',data.users||[]);closeModal('clientModal');loadClients();resetForm(['clientCompanyName','clientName','clientContactNo','clientEmail','clientWebsite','clientWhatsapp','clientPlatforms','clientDeliverables','clientOwner','clientNotes']);toast('Client saved to database')}catch(err){toast(err.message)}
}

async function saveMember(){
 if(!isManagerOrLeader()){toast('Only Managers and Team Leaders can add members');return}
 const payload={name:val('memberName'),email:val('memberEmail'),phone:val('memberPhone'),whatsapp:val('memberWhatsapp'),role:val('memberRole'),field:val('memberField'),skills:val('memberSkills'),work_model:'Platform Expert',status:val('memberStatus'),notes:val('memberNotes')};
 if(!payload.name||!payload.email){toast('Full name and login email are required');return}
 try{const data=await ttApi('create_member',payload);ttCache('tt_members',data.members||[]);ttCache('tt_users',data.users||[]);closeModal('teamModal');loadMembers();resetForm(['memberName','memberPhone','memberEmail','memberWhatsapp','memberField','memberSkills','memberNotes']);toast('Team member saved to database')}catch(err){toast(err.message)}
}

async function punchIn(){
 const u=effectiveUser();if(!u)return;
 try{const data=await ttApi('attendance',{mode:'in',user_id:u.id});ttCache('tt_attendance_db',data.attendance||[]);renderAttendanceToday();updatePunchUI();toast('Punched in and saved')}catch(err){toast(err.message)}
}
async function punchOut(){
 const u=effectiveUser();if(!u)return;
 try{const data=await ttApi('attendance',{mode:'out',user_id:u.id});ttCache('tt_attendance_db',data.attendance||[]);renderAttendanceToday();updatePunchUI();toast('Punched out and saved')}catch(err){toast(err.message)}
}
function attendanceState(){return ttRead('tt_attendance_db',{})}
function setAttendanceState(s){ttCache('tt_attendance_db',s)}

async function saveCalendarContent(){
 const payload={client:val('contentClient'),platform:val('contentPlatform'),content_type:val('contentType'),publish:val('contentPublish'),assigned:val('contentMember'),approval_chain:val('contentApproval'),work_url:val('contentWorkUrl'),title:val('contentType')+' — '+val('contentClient'),status:'Scheduled'};
 if(!payload.client||!payload.publish){toast('Client and publish date/time are required');return}
 try{const data=await ttApi('create_calendar_event',payload);ttCache('tt_tasks',data.tasks||[]);closeModal('contentModal');toast('Calendar task saved to database');go('calendar')}catch(err){toast(err.message)}
}

async function importBulkCalendar(){
 const file=document.getElementById('bulkFile')?.files?.[0];
 if(!file){toast('Choose a CSV file first');return}
 if(!file.name.toLowerCase().endsWith('.csv')){toast('CSV import is supported without extra libraries. Save Excel as CSV for import.');return}
 const text=await file.text();
 try{const data=await ttApi('bulk_import',{client:val('bulkClient'),month:val('bulkMonthSelect'),notes:val('bulkNotes'),filename:file.name,csv:text});ttCache('tt_tasks',data.tasks||[]);closeModal('bulkModal');toast((data.imported||0)+' calendar rows imported to database');go('calendar')}catch(err){toast(err.message)}
}

function ttTaskRows(){return ttRead('tt_tasks',[])}
function openTaskDetail(id){localStorage.setItem('tt_task_preview',id);go('taskDetail')}
function renderTaskDetail(id){
 const box=document.getElementById('taskDetailContent');if(!box)return;
 const task=ttTaskRows().find(t=>String(t.id)===String(id));
 if(!task){box.innerHTML='<div class="notice">Task not found.</div>';return}
 document.getElementById('taskDetailSubtitle').textContent=(task.title||'Task')+' · '+(task.client||'');
 box.innerHTML=`<div class="task-detail-grid"><div class="task-detail-card"><span>Task</span><b>${esc(task.title||'—')}</b></div><div class="task-detail-card"><span>Client</span><b>${esc(task.client||'—')}</b></div><div class="task-detail-card"><span>Platform</span><b>${esc(task.platform||'—')}</b></div><div class="task-detail-card"><span>Assigned</span><b>${esc(task.assigned||task.member||'—')}</b></div><div class="task-detail-card"><span>Due</span><b>${esc(task.due||task.date||'—')}</b></div><div class="task-detail-card"><span>Publish</span><b>${esc(task.publish||task.time||'—')}</b></div><div class="task-detail-card"><span>Status</span><b>${esc(task.status||'Planned')}</b></div><div class="task-detail-card"><span>Approval</span><b>${esc(task.approvals||task.approval_chain||'Team review')}</b></div></div><div class="panel" style="padding:0;box-shadow:none"><table class="table"><tr><th>Task Notes</th><td>${esc(task.notes||'—')}</td></tr><tr><th>Work Proof</th><td>${task.proof||task.work_url?`<a href="${esc(task.proof||task.work_url)}" target="_blank">Open Work Proof</a>`:'Not attached yet'}</td></tr><tr><th>Attachment / Work Link</th><td>${task.attachmentLink?`<a href="${esc(task.attachmentLink)}" target="_blank">Open Attachment</a>`:'—'}</td></tr></table></div><div class="quick"><button class="btn" onclick="go('tasks')">Open Tasks Page</button><button class="btn secondary" onclick="goBack()">← Back</button></div>`;
}

function buildCalendar(monthValue,filters,type){
 const box=document.getElementById(type==='team'?'teamCalendarGrid':'clientCalendarGrid');if(!box)return;
 const [year,month]=monthValue.split('-').map(Number), first=new Date(year,month-1,1),days=new Date(year,month,0).getDate(),start=(first.getDay()+6)%7;
 let html='';for(let i=0;i<start;i++)html+='<div class="day"><b></b></div>';
 const rows=ttTaskRows();
 for(let day=1;day<=days;day++){
  const date=year+'-'+String(month).padStart(2,'0')+'-'+String(day).padStart(2,'0'),today=new Date().toISOString().slice(0,10);
  const events=rows.filter(e=>String(e.publish||e.due||e.date||'').slice(0,10)===date&&(!filters.person||filters.person==='all'||(e.assigned||e.member)===filters.person)&&(!filters.client||filters.client==='all'||e.client===filters.client)&&(!filters.platform||filters.platform==='all'||e.platform===filters.platform));
  html+=`<div class="day ${date===today?'today':''}"><b>${new Date(date+'T00:00:00').toLocaleString('en-US',{weekday:'short'})} ${day}</b>${events.map(e=>`<a href="#" class="event" onclick="openTaskDetail('${esc(e.id)}');return false" style="display:block;text-decoration:none"><b>${esc(e.title||e.content_type||'Task')}</b><br>${esc((e.publish||e.time||'').slice(11,16)||e.time||'')}<br><small>${esc(e.assigned||e.member||'')} · ${esc(e.platform||'')}</small></a>`).join('')}</div>`;
 }
 box.innerHTML=html;
}

async function searchWorkRates(){
 const period=document.getElementById('workRatePeriod')?.value||'monthly',month=document.getElementById('workRateMonth')?.value||new Date().toISOString().slice(0,7);
 try{const data=await ttApi('work_rates',{period,month},'GET');document.getElementById('workRateReport').innerHTML=data.html;toast((data.label||'Report')+' loaded')}catch(err){toast(err.message)}
}

async function saveCampaign(){
 const payload={client:val('campaignClient'),platform:val('campaignPlatform'),start:val('campaignStart'),end:val('campaignEnd'),type:val('campaignType'),title:val('campaignTitle'),schedule:val('campaignSchedule'),objective:val('campaignObjective'),status:'Ready'};
 if(!payload.client||!payload.title||!payload.start){toast('Client, campaign title and start are required');return}
 try{const data=await ttApi('create_campaign',payload);ttCache('tt_campaigns',data.campaigns||[]);closeModal('campaignModal');toast('Campaign saved to database');go('campaignHistory');renderCampaignHistory()}catch(err){toast(err.message)}
}
function searchCampaigns(){
 const q=(document.getElementById('campaignSearchInput')?.value||'').toLowerCase().trim(),rows=ttCampaigns().filter(c=>!q||Object.values(c).some(v=>String(v).toLowerCase().includes(q))),table=document.getElementById('campaignCurrentTable');if(!table)return;
 table.innerHTML='<tr><th>Date</th><th>Client</th><th>Platform</th><th>Campaign</th><th>Status</th><th>View</th></tr>'+rows.map(c=>`<tr><td>${esc(c.date||String(c.start||'').slice(0,10))}</td><td>${esc(c.client)}</td><td>${esc(c.platform)}</td><td>${esc(c.title)}</td><td><span class="badge ${c.status==='Completed'?'ok':''}">${esc(c.status||'')}</span></td><td><button class="btn secondary" onclick="openCampaignDetail('${esc(c.id)}')">View</button></td></tr>`).join('')||'<tr><td colspan="6">No campaigns found.</td></tr>';
}
function renderCampaignHistory(){searchCampaignHistory()}
function searchCampaignHistory(){
 const mode=document.getElementById('campaignHistoryMode')?.value||'monthly',month=document.getElementById('campaignMonthSelect')?.value||new Date().toISOString().slice(0,7),q=(document.getElementById('campaignHistorySearch')?.value||'').toLowerCase().trim();
 const rows=ttCampaigns().filter(c=>(mode==='old'||String(c.date||c.start||'').startsWith(month))&&(!q||Object.values(c).some(v=>String(v).toLowerCase().includes(q))));
 const box=document.getElementById('campaignHistoryResults');if(!box)return;
 box.innerHTML=`<table class="table"><tr><th>Date</th><th>Client</th><th>Platform</th><th>Campaign</th><th>Type</th><th>Status</th><th>View</th></tr>${rows.map(c=>`<tr><td>${esc(c.date||String(c.start||'').slice(0,10))}</td><td>${esc(c.client)}</td><td>${esc(c.platform)}</td><td>${esc(c.title)}</td><td>${esc(c.type||'')}</td><td><span class="badge ${c.status==='Completed'?'ok':''}">${esc(c.status||'')}</span></td><td><button class="btn secondary" onclick="openCampaignDetail('${esc(c.id)}')">View</button></td></tr>`).join('')||'<tr><td colspan="7">No campaign records found.</td></tr>'}</table>`;
}
function openCampaignDetail(id){localStorage.setItem('tt_campaign_preview',id);go('campaignDetail')}
function renderCampaignDetail(id){const c=ttCampaigns().find(x=>String(x.id)===String(id)),box=document.getElementById('campaignDetailContent');if(!box)return;if(!c){box.innerHTML='<div class="notice">Campaign not found.</div>';return}document.getElementById('campaignDetailSubtitle').textContent=(c.title||'Campaign')+' · '+c.client;box.innerHTML=`<div class="kpis"><div class="kpi">Client<b>${esc(c.client)}</b></div><div class="kpi">Platform<b>${esc(c.platform)}</b></div><div class="kpi">Type<b>${esc(c.type)}</b></div><div class="kpi">Status<b>${esc(c.status)}</b></div></div><div class="panel" style="margin-top:14px;padding:0;box-shadow:none"><table class="table"><tr><th>Campaign</th><td>${esc(c.title)}</td></tr><tr><th>Date</th><td>${esc(c.date||String(c.start||'').slice(0,10))}</td></tr><tr><th>Schedule</th><td>${esc(c.schedule||'—')}</td></tr><tr><th>Objective</th><td>${esc(c.objective||'—')}</td></tr></table></div>`}

async function searchClientGrowth(){
 const id=document.getElementById('growthClientSelect')?.value||'';if(!id){toast('Select a client first');return}
 try{const data=await ttApi('client_growth',{client_id:id},'GET');['growthViews','growthLeads','growthLikes','growthFollowers'].forEach((x,i)=>{const e=document.getElementById(x);if(e)e.textContent=data.kpis[i]||'0'});document.getElementById('growthTimeline').innerHTML=(data.timeline||[]).map(x=>`<div class="item"><b>${esc(x.title)}</b><br>${esc(x.description)}</div>`).join('')||'<div class="notice">No growth history found.</div>';toast('Client growth report loaded')}catch(err){toast(err.message)}
}

function populateIntegrationClients(){const s=document.getElementById('integrationClientSelect');if(!s)return;const cur=s.value;s.innerHTML='<option value="">Select Client</option>'+getClients().map(c=>`<option value="${esc(c.id)}">${esc(c.name)}</option>`).join('');if(cur)s.value=cur;}
async function saveIntegration(){
 const payload={client_id:document.getElementById('integrationClient')?.value||'',platform:val('integrationPlatform'),account:val('integrationAccount'),status:val('integrationStatus'),actions:val('integrationActions')};
 if(!payload.client_id||!payload.account){toast('Client and client account are required');return}
 try{const data=await ttApi('save_integration',payload);ttCache('tt_connections',data.connections||{});closeModal('integrationModal');toast('Client connection saved to database');populateIntegrationClients()}catch(err){toast(err.message)}
}
function searchClientIntegrations(){const id=document.getElementById('integrationClientSelect')?.value||'';if(!id){toast('Select a client first');return}localStorage.setItem('tt_integration_client',id);go('integrationClientReport')}
function renderIntegrationClientReport(id){const c=getClients().find(x=>String(x.id)===String(id)),box=document.getElementById('integrationClientContent');if(!box)return;if(!c){box.innerHTML='<div class="notice">Client not found.</div>';return}const all=ttConnections(),rows=all[id]||[];document.getElementById('integrationClientSubtitle').textContent=c.name+' · platform connection details';box.innerHTML=`<div class="kpis"><div class="kpi">Client<b>${esc(c.name)}</b></div><div class="kpi">Platforms<b>${esc(c.platforms||'—')}</b></div><div class="kpi">Connected<b>${rows.filter(r=>r.status==='Connected').length}</b></div><div class="kpi">Needs Setup<b>${rows.filter(r=>r.status!=='Connected').length}</b></div></div><table class="table"><tr><th>Platform</th><th>Client Account</th><th>Status</th><th>Connected On</th><th>Available Actions</th></tr>${rows.map(r=>`<tr><td>${esc(r.platform)}</td><td>${esc(r.account)}</td><td><span class="badge ${r.status==='Connected'?'ok':'warn'}">${esc(r.status)}</span></td><td>${esc(r.connectedOn||'—')}</td><td>${esc(r.actions||'—')}</td></tr>`).join('')||'<tr><td colspan="5">No connections saved for this client.</td></tr>'}</table>`}

function openMeetingSearch(){const e=document.getElementById('meetingSearchBar');if(e)e.style.display='flex';document.getElementById('meetingSearchInput')?.focus()}
function closeMeetingSearch(){const e=document.getElementById('meetingSearchBar');if(e)e.style.display='none'}
function searchMeetings(){const q=(document.getElementById('meetingSearchInput')?.value||'').toLowerCase().trim(),rows=ttMeetings().filter(m=>!q||Object.values(m).some(v=>String(v).toLowerCase().includes(q))),box=document.getElementById('meetingSearchResults');if(!box)return;box.innerHTML=`<table class="table"><tr><th>Date</th><th>Meeting</th><th>Client</th><th>Participants</th><th>View</th></tr>${rows.map(m=>`<tr><td>${esc(m.date)} · ${esc(m.time)}</td><td>${esc(m.title)}</td><td>${esc(m.client)}</td><td>${esc(m.participants)}</td><td><button class="btn secondary" onclick="openMeetingDetail('${esc(m.id)}')">View</button></td></tr>`).join('')||'<tr><td colspan="5">No meetings found.</td></tr>'}</table>`}
function showMeetingHistory(mode='monthly'){const s=document.getElementById('meetingHistoryMode');if(s)s.value=mode;renderMeetingHistory()}
function renderMeetingHistory(){searchMeetingHistory()}
function searchMeetingHistory(){const mode=document.getElementById('meetingHistoryMode')?.value||'monthly',month=document.getElementById('meetingMonthSelect')?.value||new Date().toISOString().slice(0,7),date=document.getElementById('meetingDateSelect')?.value||'',q=(document.getElementById('meetingHistorySearch')?.value||'').toLowerCase().trim(),rows=ttMeetings().filter(m=>(mode==='date'?(date?m.date===date:true):String(m.date).startsWith(month))&&(!q||Object.values(m).some(v=>String(v).toLowerCase().includes(q)))),box=document.getElementById('meetingHistoryResults');if(!box)return;box.innerHTML=`<table class="table"><tr><th>Date</th><th>Meeting</th><th>Client</th><th>Participants</th><th>Status</th><th>View</th></tr>${rows.map(m=>`<tr><td>${esc(m.date)} · ${esc(m.time)}</td><td>${esc(m.title)}</td><td>${esc(m.client)}</td><td>${esc(m.participants)}</td><td><span class="badge ok">${esc(m.status||'Scheduled')}</span></td><td><button class="btn secondary" onclick="openMeetingDetail('${esc(m.id)}')">View</button></td></tr>`).join('')||'<tr><td colspan="6">No meeting records found.</td></tr>'}</table>`}
function openMeetingDetail(id){localStorage.setItem('tt_meeting_preview',id);go('meetingDetail')}
function renderMeetingDetail(id){const m=ttMeetings().find(x=>String(x.id)===String(id)),box=document.getElementById('meetingDetailContent');if(!box)return;if(!m){box.innerHTML='<div class="notice">Meeting not found.</div>';return}document.getElementById('meetingDetailSubtitle').textContent=(m.title||'Meeting')+' · '+m.client;box.innerHTML=`<div class="kpis"><div class="kpi">Date<b>${esc(m.date)}</b></div><div class="kpi">Time<b>${esc(m.time)}</b></div><div class="kpi">Client<b>${esc(m.client)}</b></div><div class="kpi">Status<b>${esc(m.status||'Scheduled')}</b></div></div><table class="table"><tr><th>Meeting</th><td>${esc(m.title)}</td></tr><tr><th>Participants</th><td>${esc(m.participants)}</td></tr><tr><th>Agenda</th><td>${esc(m.agenda)}</td></tr><tr><th>Notes</th><td>${esc(m.notes)}</td></tr><tr><th>Follow-ups</th><td>${esc(m.followups)}</td></tr></table>`}
async function saveMeeting(){
 const payload={date:val('meetingDate'),time:val('meetingTime'),title:val('meetingTitle'),client:val('meetingClient'),participants:val('meetingParticipants'),agenda:val('meetingAgenda'),notes:val('meetingNotes'),followups:val('meetingFollowups'),status:val('meetingStatus')};
 if(!payload.date||!payload.time||!payload.title||!payload.client){toast('Date, time, title and client are required');return}
 try{const data=await ttApi('create_meeting',payload);ttCache('tt_meetings',data.meetings||[]);closeModal('meetingModal');resetForm(['meetingDate','meetingTime','meetingTitle','meetingParticipants','meetingAgenda','meetingNotes','meetingFollowups']);toast('Meeting saved to database');go('meetings')}catch(err){toast(err.message)}
}

async function saveApproval(){
 const payload={client:val('approvalClient'),item:val('approvalItem'),tags:val('approvalTags'),rule:val('approvalRule'),status:'Pending'};
 if(!payload.client||!payload.item){toast('Client and task/deliverable are required');return}
 try{const data=await ttApi('create_approval',payload);ttCache('tt_approvals',data.approvals||[]);closeModal('approvalModal');toast('Approval chain saved to database');go('approvals')}catch(err){toast(err.message)}
}

/* Re-hydrate after page-changing mutations and populate DB-driven filters. */
const ttOriginalGo=go;
go=async function(id,btn,skipHistory=false){
  ttOriginalGo(id,btn,skipHistory);
  if(id==='clients'||id==='team'||id==='tasks'||id==='calendar'||id==='performance'||id==='campaigns'||id==='campaignHistory'||id==='milestones'||id==='integrations'||id==='meetings'||id==='meetingHistory'||id==='clientReports'){
    // Data was already loaded at login; refresh quietly in the background.
    ttHydrate(true).then(()=>{
      if(id==='clients')loadClients();
      if(id==='team')loadMembers();
      if(id==='calendar'){populateCalendarControls();searchTeamCalendar();searchClientCalendar();}
      if(id==='performance')searchWorkRates();
      if(id==='campaignHistory')renderCampaignHistory();
      if(id==='campaignDetail')renderCampaignDetail(localStorage.getItem('tt_campaign_preview'));
      if(id==='meetings')searchMeetings();
      if(id==='meetingHistory')renderMeetingHistory();
      if(id==='integrations')populateIntegrationClients();
      if(id==='clientReports')loadClientReportList();
    });
  }
};

/* Replace initial page setup so the DB is queried before the first screen is rendered. */
const ttOriginalSetupMobileNav=setupMobileNav;
// keep the existing mobile behavior untouched
setupMobileNav=ttOriginalSetupMobileNav;

/* Initial silent database hydration. The existing DOMContentLoaded handler remains responsible for UI boot. */
window.addEventListener('load',()=>{ttHydrate(true)});

</script>
</body>
</html>