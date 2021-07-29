jQuery(document).ready(function ($) {

    $(".helpful-yes-no span").on('click', function () {

        let helpfulCookie = getCookie('helpful');

        let post_id = helpfulData.id;

        let value = parseInt($(this).attr("data-value"));

        let votes = helpfulData.positive[0];

        if (helpfulCookie.includes(post_id)) {
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

            if (value == 1) {
                $(".helpful-votes").fadeOut(333, function () {
                    $(this).text(++votes).fadeIn(333);
                });

                setTimeout(function () {
                    $(".kentaurus-helpful").hide();

                    $(".helpful-thank-you").show();
                }, 1000);
            } else {
                $(".kentaurus-helpful").hide();
                $(".helpful-thank-you").show();
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