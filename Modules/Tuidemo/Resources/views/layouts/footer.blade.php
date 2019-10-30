<div class="footer">
    <div class="container">
        <div class="col-md-12">
            <ul>
                 @foreach (footers_by_whitelabel() as $footer)
                     <li>
                        <a href="{{ $footer->url }}" target="_blank">{{ $footer->name }}</a>
                    </li>
                @endforeach
            </ul>
            <div class="tui-footer">
                <div class="tui-footer-certs">
                    <div class="container">
                        <div class="tui-row-d" style="display: inline-flex">
                            <div>
                                <img src="https://www.tui.com/fileadmin/redaktion/footer/footer_ssl.png" style="float: left;clear:left;margin-right:10px;margin-bottom:25px;">
                                <strong style="display: block;font-family: 'TUITypeLight',sans-serif; font-weight: bold; font-size: 16px;">SSL-Verschlüsselung</strong>
                                Wir übertragen alle Daten mit der sicheren SSL-Verschlüsselung.
                            </div>
                            <div>
                                <img src="https://www.tui.com/fileadmin/redaktion/footer/footer_thawte.png" style="float: left;clear:left;margin-right:10px;margin-bottom:25px;">
                                <strong style="display: block;font-family: 'TUITypeLight',sans-serif; font-weight: bold; font-size: 16px;">Online-Sicherheit</strong>
                                Die verschlüsselte Übertragung erfolgt Thawte-Zertifiziert.
                            </div>
                            <div>
                                <img src="https://www.tui.com/fileadmin/redaktion/footer/footer_tuev.png" style="float: left;clear:left;margin-right:10px;margin-bottom:25px;">
                                <strong style="display: block;font-family: 'TUITypeLight',sans-serif; font-weight: bold; font-size: 16px;">Objektiv und zertifiziert</strong>
                                Der TÜV Saarland hat die TUI Gästebefragung mit "sehr gut" ausgezeichnet.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <nav>
                        <ul style="font-size: 10px;font-weight: bold;list-style: none;padding: 10px 0 0 0;margin: 0;">
                            <li><a href="https://flug.tui.com/?agent=tuicom" rel="nofollow" style="color: #252525;text-decoration: none">TUI Flug</a></li>
                            <li><a href="http://www.tui-shop.com" rel="nofollow" style="color: #252525;text-decoration: none">TUI Shop</a></li>
                            <li><a href="http://www.tuigroup.com" rel="nofollow" style="color: #252525;text-decoration: none">TUI Group</a></li>
                            <li><a href="https://www.tuigroup.com/de-de/medien" rel="nofollow" style="color: #252525;text-decoration: none">Presse</a></li>
                            <li><a href="http://www.tui-group.com/de/jobcareer" rel="nofollow" style="color: #252525;text-decoration: none">Jobs</a></li>
                            <li><a href="http://tui.com/nutzungsbedingungen/" target="_top" style="color: #252525;text-decoration: none">Nutzungsbedingungen</a></li>
                            <li><a href="http://tui.com/datenschutz/" target="_top" style="color: #252525;text-decoration: none">Datenschutz</a></li>
                            <li><a href="http://tui.com/impressum/" target="_top" style="color: #252525;text-decoration: none">Impressum</a></li>
                            <li><a href="http://tui.com/service-kontakt/agb-und-allgemeine-geschaeftsbedingungen/" target="_top" style="color: #252525;text-decoration: none">AGB</a></li>
                            <li><a href="http://tui.com/service-kontakt/kontakt/" target="_top" style="color: #252525;text-decoration: none">Service &amp; Kontakt</a></li>
                            <li style="color: #252525;text-decoration: none">© TUI Deutschland GmbH</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>