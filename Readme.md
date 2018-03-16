# TYPO3 Extension 'news_like'

[![Donate](https://img.shields.io/badge/Donate-PayPal-green.svg)](https://www.paypal.me/GeorgRinger/19.99)
[![License](https://poser.pugx.org/georgringer/news-like/license)](https://packagist.org/packages/georgringer/news-like)


This extension makes it possible to add a simple like button to a news record and to show the amount of likes.

## Requirements

- TYPO3 8.7 LTS
- EXT:news 6+

## Usage

1) Install the extension by either use composer `composer require georgringer/news-like` or by downloading it from the TER.

2) Adopt the `Detail` template by adding something like this

```
<button 
    class="news-like-js" 
    data-news="{newsItem.uid}" 
    data-hash="{newsItem.txNewslikeHash}">like me
</button>
<div class="news-like-text-js" style="display: none">
    This news has been liked <span>0</span> times.
</div>
```

3) Embed the JS shipped with the extension or adopt it to your needs. It can be found at `EXT:news_like/Resources/Public/JavaScript/newsLike.js`.

## Sponsor

This extension has been sponsored by **Steindesign Werbeagentur GmbH** from Hannover, Germany - https://www.steindesign.de/. 

Thanks a lot!