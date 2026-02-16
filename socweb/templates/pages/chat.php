<link rel="stylesheet" href="/css/chat.css">

<section>
    <div class="panel">
        <div id="room">
            <div class="msg -my">
                <div class="img" style="background-image: url(/img/profile.jpg)"></div>
                <div class="-top"><b>Сергеев Д.Н.</b>
                    <small>15:36</small>
                </div>
                <div class="text">Что тут происходит?</div>
            </div>

            <div class="msg">
                <div class="img" style="background-image: url(/img/frind1.png)"></div>
                <div class="-top"><b>Иванов Иван Иванович</b>
                    <small>15:37</small>
                </div>
                <div class="text">Ничего</div>
            </div>

            <div class="msg">
                <div class="img" style="background-image: url(/img/frind3.webp)"></div>
                <div class="-top"><b>Иванов Иван Иванович</b>
                    <small>15:46</small>
                </div>
                <div class="text">Ничего</div>
            </div>

            <div class="msg">
                <div class="img" style="background-image: url(/img/frind4.webp)"></div>
                <div class="-top"><b>Иванов Иван Иванович</b>
                    <small>16:06</small>
                </div>
                <div class="text">Ничего</div>
            </div>

            <div class="msg -my">
                <div class="img" style="background-image: url(/img/profile.jpg)"></div>
                <div class="-top"><b>Сергеев Д.Н.</b>
                    <small>15:36</small>
                </div>
                <div class="text">А почему?</div>
            </div>


            <div class="msg -my">
                <div class="img" style="background-image: url(/img/profile.jpg)"></div>
                <div class="-top"><b>Сергеев Д.Н.</b>
                    <small>15:36</small>
                </div>
                <div class="text">Что тут происходит?</div>
            </div>

            <div class="msg">
                <div class="img" style="background-image: url(/img/frind1.png)"></div>
                <div class="-top"><b>Иванов Иван Иванович</b>
                    <small>15:37</small>
                </div>
                <div class="text">Ничего</div>
            </div>

            <div class="msg">
                <div class="img" style="background-image: url(/img/frind3.webp)"></div>
                <div class="-top"><b>Иванов Иван Иванович</b>
                    <small>15:46</small>
                </div>
                <div class="text">Ничего</div>
            </div>

            <div class="msg">
                <div class="img" style="background-image: url(/img/frind4.webp)"></div>
                <div class="-top"><b>Иванов Иван Иванович</b>
                    <small>16:06</small>
                </div>
                <div class="text">Ничего</div>
            </div>

            <div class="msg -my">
                <div class="img" style="background-image: url(/img/profile.jpg)"></div>
                <div class="-top"><b>Сергеев Д.Н.</b>
                    <small>15:36</small>
                </div>
                <div class="text">А почему?</div>
            </div>
        </div>
    </div>
    
    <div class="panel form-send">
        <form action="/admin/chat/room/send" method="post">
            <input type="hidden" name="rid" value="">
            <textarea name="msg" rows=10 cols=60></textarea><br>
            <input type="submit" value="Отправить">
        </form>
    </div>
</section>