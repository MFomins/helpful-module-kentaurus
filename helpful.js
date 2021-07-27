jQuery(document).ready(function ($) {

    $(".wthf-yes-no span").on('click', function () {

        let helpfulCookie = getCookie('helpful');

        let post_id = helpfulData.id;

        let votes = helpfulData.positive[0];

        let value = parseInt($(this).attr("data-value"));

        if(helpfulCookie.includes(post_id)){
            return false;
        }

        index = helpfulCookie.indexOf(post_id);
        if (index == -1) {
            // if the id is not in the array the push it
            helpfulCookie.push(post_id);
        }

        // Send Ajax
        $.post(helpfulData.ajaxurl, {
            action: "wthf_ajax",
            id: post_id,
            val: value,
            nonce: helpfulData.nonce_wthf
        }).done(function () {
            setCookie("helpful", JSON.stringify(helpfulCookie), 30);
            $(".betspin-helpful").hide();

            $(".helpful-thank-you").show();

            if(value == 1) {
                setTimeout(function () {
                    $(".helpful-votes").fadeOut(250, function () {
                        $(this).text(++votes).fadeIn(250);
                    });
                }, 100);
            }

        });

        // Function to read cookie and return as JSON
        function getCookie(name) {
            let a = `; ${document.cookie}`.match(`;\\s*${name}=([^;]+)`);
            return a ? JSON.parse(a[1]) : [];
        }

        function setCookie(name, value, days) {
            let expires = "";
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + (value || "") + expires + "; path=/";

        }

    });

});