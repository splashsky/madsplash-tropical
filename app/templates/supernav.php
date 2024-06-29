<section id="SuperNav">
    <?php if(!empty($_COOKIE['MadSplashUser'])): ?>
        <div class="left" style="padding-left: 12px;">
            Heyas, <a href="#">{$user[1]}</a>! You can go to your <a href="#">User CP</a> or <a href="http://localhost:8888/Resources/Scripts/PHP/Hubs/CommunityHub.php?user={$user[0]}&action=logout">logout</a>.
        </div>
    <?php else: ?>
        <div class="left" style="padding-left: 12px;">
            Hey there, Guest. You can <a href="http://localhost:8888/community/index.php?page=login">login</a>
            or <a href="http://localhost:8888/community/index.php?page=register">register</a> here.
        </div>
    <?php endif; ?>

    <div class="right">
        <a class="YouTube" href="http://youtube.com/User/MadSplashTV" target="_blank">&nbsp;</a>
        <a class="Twitter" href="http://twitter.com/MadSplashStudio" target="_blank">&nbsp;</a>

        <div class="CrossNav">
            <img src="/assets/images/Icons/General/CrossNavDark.png" style="width: 28px; height: 28px;" />

            <ul>
                <a href="http://therpg.madsplash.net/" target="_blank">
                    <li class="RPG">
                        <img src="/assets/images/Logos/TheRPG.png" style="width: 38px; float: left; margin-right: 4px; margin-top: 4px;" />

                        <a class="RPGLink">The RPG</a> <br />
                        Our up-and-coming web-and-text-based RPG. Play!
                    </li>
                </a>

                <li class="footer">
                    <div style="padding: 4px 8px;">
                        Follow us here, too: <br />

                        <div class="right">
                            <a class="YouTube" href="http://youtube.com/User/MadSplashTV" target="_blank">&nbsp;</a>
                            <a class="Twitter" href="http://twitter.com/MadSplashStudio" target="_blank">&nbsp;</a>
                        </div>

                        <div class="clear"> </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</section>
