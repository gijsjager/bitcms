<div class="container margin-top">
    <div class="newsletter">
        <div class="col-md-6">
            <div class="row">
                <div class="newsletter-left">
                    <div class="newsletter-left-inner">
                        <h1>WIL JE OOK MEER INFO <br>OVER EEN NIEUWE <b>WEBSITE</b></h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="newsletter-right" style="background: url(<?= $this->Url->build('img/newsletter-bg.jpg')?>)">
                    <div class="newsletter-right-inner">
                        <form>
                            <input type="text" name="email" required="true" placeholder="Wat is jouw e-mailadres?">
                            <input type="submit" value="VERSTUUR">
                            <p class="hidden">
                                Bedankt voor het invullen! Wij zullen zo snel mogelijk reageren.
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="footer margin-top">
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-sm-4 col-xs-12">
                <div class="footer-inner">
                    <div class="footer-content">
                        <h4>Dotbits</h4>
                        <address>
                            <?php echo $settings['ADDRESS'] ?>
                        </address>
                    </div>
                </div>
            </div>

            <div class="col-md-2 col-md-push-8 col-sm-4 col-xs-12">
                <div class="footer-inner">
                    <div class="footer-content">
                        <h4>CONTACT INFO</h4>
                        <p>

                            E: <?php echo $this->Html->link('mail@dotbits.nl', 'mailto:mail@dotbits.nl') ?><br>
                            W: <?php echo $this->Html->link('www.dotbits.nl', 'https://dotbits.nl/') ?>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="footer-inner">
                    <div class="footer-content">
                        <ul class="social-media">
                            <li><a href="https://www.facebook.com/gijsjager13"><i class="iconmoon-facebook"></i></a></li>
                            <li><a href="https://www.linkedin.com/in/gijsjager/"><i class="iconmoon-linkedin2"></i></a></li>
                        </ul>
                        <span class="copyright-mark">© 2018 DOTBITS, ALL RIGHTS RESERVED</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<a href="javascript:void(0)" class="scroll-top" id="scroll-top"><i class="pe-7s-angle-up"></i></a>