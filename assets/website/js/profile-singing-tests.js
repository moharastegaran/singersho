$(window).on("load",function (){

   $.get(__url__+"/singing",function (response){
       if(response!==null && typeof response === 'object'){
           if(!response.error){
               const tests = response.tests;
               for (let i = 0; i < tests.length; i++) {
                   $(".singing_tests_table tbody").append("" +
                       "<tr>\n" +
                       "                                                    <td>\n" +
                       "                                                        <div class=\"main__table-text main__table-text--number\">\n" +
                       "                                                            <a href=\"javascript:void(0)\">"+tests[i].id+"</a>\n" +
                       "                                                        </div>\n" +
                       "                                                    </td>\n" +
                       "                                                    <td>\n" +
                       "                                                        <div class=\"main__table-text main__table-text--green\">\n" +
                       "                                                            <a data-link data-title=\"تست خوانندگی\" data-artist=\"\"\n" +
                       "                                                               href=\""+tests[i].file+"\">\n" +
                       "                                                                <i class=\"icofont-ui-play ml-1\"></i>\n" +
                       "                                                                پخش فایل\n" +
                       "                                                            </a>\n" +
                       "                                                        </div>\n" +
                       "                                                    </td>\n" +
                       "                                                    <td>\n" +
                       "                                                        <div class=\"main__table-text "+(tests[i].response===null ? 'main__table-text--grey' : 'main__table-text--green')+"\" style=\"font-size: 13px\">\n" +
                       (tests[i].response!==null ? tests[i].response : 'در انتظار پاسخ پشتیبان')+
                       "                                                        </div>\n" +
                       "                                                    </td>\n" +
                       "</tr>")
               }
           }
       }
   })

});

$(document).ready(function (){

    $('.player__btn').on('click', function() {
        $(this).toggleClass('player__btn--active');
        $('.player').toggleClass('player--active');
    });

    const controls = `
	<div class="plyr__controls">
		<div class="plyr__actions">
			<button type="button" class="plyr__control plyr__control--prev">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M20.28,3.43a3.23,3.23,0,0,0-3.29,0L8,8.84V6A3,3,0,0,0,2,6V18a3,3,0,0,0,6,0V15.16l9,5.37a3.28,3.28,0,0,0,1.68.47,3.24,3.24,0,0,0,1.61-.43,3.38,3.38,0,0,0,1.72-3V6.42A3.38,3.38,0,0,0,20.28,3.43ZM6,18a1,1,0,0,1-2,0V6A1,1,0,0,1,6,6Zm14-.42a1.4,1.4,0,0,1-.71,1.25,1.23,1.23,0,0,1-1.28,0L8.68,13.23a1.45,1.45,0,0,1,0-2.46L18,5.19A1.23,1.23,0,0,1,18.67,5a1.29,1.29,0,0,1,.62.17A1.4,1.4,0,0,1,20,6.42Z"/></svg>
			</button>

			<button type="button" class="plyr__control" data-plyr="play">
				<svg class="icon--pressed" role="presentation" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M16,2a3,3,0,0,0-3,3V19a3,3,0,0,0,6,0V5A3,3,0,0,0,16,2Zm1,17a1,1,0,0,1-2,0V5a1,1,0,0,1,2,0ZM8,2A3,3,0,0,0,5,5V19a3,3,0,0,0,6,0V5A3,3,0,0,0,8,2ZM9,19a1,1,0,0,1-2,0V5A1,1,0,0,1,9,5Z"></path></svg>
				<svg class="icon--not-pressed" role="presentation" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M18.54,9,8.88,3.46a3.42,3.42,0,0,0-5.13,3V17.58A3.42,3.42,0,0,0,7.17,21a3.43,3.43,0,0,0,1.71-.46L18.54,15a3.42,3.42,0,0,0,0-5.92Zm-1,4.19L7.88,18.81a1.44,1.44,0,0,1-1.42,0,1.42,1.42,0,0,1-.71-1.23V6.42a1.42,1.42,0,0,1,.71-1.23A1.51,1.51,0,0,1,7.17,5a1.54,1.54,0,0,1,.71.19l9.66,5.58a1.42,1.42,0,0,1,0,2.46Z"></path></svg>
			</button>

			<button type="button" class="plyr__control plyr__control--next">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M19,3a3,3,0,0,0-3,3V8.84L7,3.47a3.21,3.21,0,0,0-3.29,0A3.38,3.38,0,0,0,2,6.42V17.58a3.38,3.38,0,0,0,1.72,3A3.24,3.24,0,0,0,5.33,21,3.28,3.28,0,0,0,7,20.53l9-5.37V18a3,3,0,0,0,6,0V6A3,3,0,0,0,19,3ZM15.32,13.23,6,18.81a1.23,1.23,0,0,1-1.28,0A1.4,1.4,0,0,1,4,17.58V6.42a1.4,1.4,0,0,1,.71-1.25A1.29,1.29,0,0,1,5.33,5,1.23,1.23,0,0,1,6,5.19l9.33,5.58a1.45,1.45,0,0,1,0,2.46ZM20,18a1,1,0,0,1-2,0V6a1,1,0,0,1,2,0Z"/></svg>
			</button>
		</div>

		<div class="plyr__wrap">
			<div class="plyr__progress">
				<input data-plyr="seek" type="range" min="0" max="100" step="0.01" value="0" aria-label="Seek">
				<progress class="plyr__progress__buffer" min="0" max="100" value="0">% buffered</progress>
				<span role="tooltip" class="plyr__tooltip">00:00</span>
			</div>

			<div class="plyr__time plyr__time--current" aria-label="Current time">00:00</div>
		</div>

		<div class="plyr__wrap">
			<button type="button" class="plyr__control" aria-label="Mute" data-plyr="mute">
				<svg class="icon--pressed" role="presentation" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12.43,4.1a1,1,0,0,0-1,.12L6.65,8H3A1,1,0,0,0,2,9v6a1,1,0,0,0,1,1H6.65l4.73,3.78A1,1,0,0,0,12,20a.91.91,0,0,0,.43-.1A1,1,0,0,0,13,19V5A1,1,0,0,0,12.43,4.1ZM11,16.92l-3.38-2.7A1,1,0,0,0,7,14H4V10H7a1,1,0,0,0,.62-.22L11,7.08ZM19.91,12l1.8-1.79a1,1,0,0,0-1.42-1.42l-1.79,1.8-1.79-1.8a1,1,0,0,0-1.42,1.42L17.09,12l-1.8,1.79a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0l1.79-1.8,1.79,1.8a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z"/></svg>
				<svg class="icon--not-pressed" role="presentation" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12.43,4.1a1,1,0,0,0-1,.12L6.65,8H3A1,1,0,0,0,2,9v6a1,1,0,0,0,1,1H6.65l4.73,3.78A1,1,0,0,0,12,20a.91.91,0,0,0,.43-.1A1,1,0,0,0,13,19V5A1,1,0,0,0,12.43,4.1ZM11,16.92l-3.38-2.7A1,1,0,0,0,7,14H4V10H7a1,1,0,0,0,.62-.22L11,7.08ZM19.66,6.34a1,1,0,0,0-1.42,1.42,6,6,0,0,1-.38,8.84,1,1,0,0,0,.64,1.76,1,1,0,0,0,.64-.23,8,8,0,0,0,.52-11.79ZM16.83,9.17a1,1,0,1,0-1.42,1.42A2,2,0,0,1,16,12a2,2,0,0,1-.71,1.53,1,1,0,0,0-.13,1.41,1,1,0,0,0,1.41.12A4,4,0,0,0,18,12,4.06,4.06,0,0,0,16.83,9.17Z"/></svg>
				<span class="label--pressed plyr__tooltip" role="tooltip">Unmute</span>
				<span class="label--not-pressed plyr__tooltip" role="tooltip">Mute</span>
			</button>

			<div class="plyr__volume">
				<input data-plyr="volume" type="range" min="0" max="1" step="0.05" value="1" autocomplete="off" aria-label="Volume">
			</div>

<!--			<a href="release.html" class="plyr__control" aria-label="لیست پخش">-->
<!--				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M15,13H9a1,1,0,0,0,0,2h6a1,1,0,0,0,0-2Zm0-4H9a1,1,0,0,0,0,2h6a1,1,0,0,0,0-2ZM12,2A10,10,0,1,0,22,12,10,10,0,0,0,12,2Zm0,18a8,8,0,1,1,8-8A8,8,0,0,1,12,20Z"/></svg>-->
<!--				<span class="plyr__tooltip" role="tooltip">لیست پخش</span>-->
<!--			</a>-->
		</div>
	</div>
    `;
    const player = new Plyr('#audio', {
        controls,
        volume: 0.5,
    });

    const audio = $('#audio');

    player.on('play', event => {
        $('a[data-link].active, a[data-playlist].active').addClass('play');
        $('a[data-link].active, a[data-playlist].active').removeClass('pause');
    });

    player.on('pause', event => {
        $('a[data-link].active, a[data-playlist].active').removeClass('play');
        $('a[data-link].active, a[data-playlist].active').addClass('pause');
    });

    /* single */
    $(document).on('click','a[data-link]', function(e){
        e.preventDefault();
        let link = $(this);
        run(link, audio[0]);
    });

    function run(link, player){
        if (link.hasClass('play')) {
            link.removeClass('play');
            audio[0].pause();
            link.addClass('pause');
        }
        else if (link.hasClass('pause')) {
            link.removeClass('pause');
            audio[0].play();
            link.addClass('play');
        }
        else {
            $('a[data-link]').removeClass('active');
            $('a[data-link]').removeClass('pause');
            $('a[data-link]').removeClass('play');
            link.addClass('active');
            link.addClass('play');
            player.src = link.attr('href');

            let title = link.data('title');
            let img = link.data('img');
            $('.player__title').text(title);
            $('.player__cover img').attr('src', img);
            audio[0].load();
            audio[0].play();
        }
    }
})