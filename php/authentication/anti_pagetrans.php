<?php
//Session starts
session_start();

if (!isset($_SESSION['flg']) && $_SESSION['flg'] !== "ok") {
    echo '
        <div align="center">
            <h1>You dont have a permission to display this page.</h1>
            <p style="color : red;">
            Direct access to this page is prohibited.
            </p>
            <p><strong>If you have disabled cookies, please enable them.</strong></p>
            <p>
                <ul style=" list-style-type: none;">
                    <li><a href="https://support.google.com/chrome/answer/95647?co=GENIE.Platform%3DDesktop&hl=en" target="_blank">Clear, allow, & manage cookies in Chrome</a></li>
                    <li><a href="https://support.mozilla.org/en/kb/enable-and-disable-cookies-website-preferences" target="_blank">Enhanced Tracking Protection in Firefox for desktop</a></li>
                    <li><a href="https://support.microsoft.com/en/help/17442/windows-internet-explorer-delete-manage-cookies" target="_blank">Delete and manage cookies</a></li>
                </ul>
            </p>
        </div><!--div center-->
    ';
    exit();
} else {
    $_SESSION = array();

    // Delete cookies
    if (isset($_COOKIE['PHPSESSID'])) {
        setcookie('PHPSESSID', '', time() - 42000, '/');
    }

    // Destroy sessions
    session_destroy();
}
