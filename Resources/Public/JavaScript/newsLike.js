$(document).ready(function () {

    var firstNewsElement = $('.news-like-js').first();

    var newsId = firstNewsElement.data('news'),
        newsHash = firstNewsElement.data('hash');

    // like and unlike click
    $('.news-like-js').click(function () {

        // AJAX Request
        $.ajax({
            url: '/index.php?eID=tx_newslike',
            type: 'post',
            data: {
                action: 'count',
                news: newsId,
                hash: newsHash
            },
            dataType: 'json',
            success: function (data) {
                var text = $('.news-like-text-js');
                text.show();
                text.find('span').text(data.count);
                $('.news-like-js').hide();
                disableUserToVote(newsId);
            }
        });
    });

    // AJAX Request
    $.ajax({
        url: '/index.php?eID=tx_newslike',
        type: 'post',
        data: {
            action: 'data',
            news: newsId,
            hash: newsHash
        },
        dataType: 'json',
        success: function (data) {
            var text = $('.news-like-text-js');
            text.show();
            text.find('span').text(data.count);
            if (checkIfUserIsAllowedToVote(newsId)) {
                $('.news-like-js').hide();
            }
        }
    });

    function checkIfUserIsAllowedToVote(newsId) {
        var key = 'newsLike_' + newsId;
        var result = localStorage.getItem(key);
        return !!result;
    }

    function disableUserToVote(newsId) {
        var key = 'newsLike_' + newsId;
        localStorage.setItem(key, '1');
    }
});