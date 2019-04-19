<?php

// For more details: https://en.gravatar.com/site/implement/images/

return [

    /* -----------------------------------------------------------------
     |  Default
     | -----------------------------------------------------------------
     |  The default avatar to display if we have no results.
     |
     |  Supported: 'identicon', '404', 'mp', 'monsterid', 'wavatar', 'retro', 'robohash', 'blank', false
     */

    'default' => 'identicon',

    /* -----------------------------------------------------------------
     |  Size
     | -----------------------------------------------------------------
     |  The default avatar size.
     */

    'size' => 80,

    /* -----------------------------------------------------------------
     |  Rating
     | -----------------------------------------------------------------
     |  Set the type of avatars we allow to show.
     |
     |  Supported:
     |    * 'g'  : suitable for display on all websites with any audience type.
     |    * 'pg' : may contain rude gestures, provocatively dressed individuals, the lesser swear words, or mild violence.
     |    * 'r'  : may contain such things as harsh profanity, intense violence, nudity, or hard drug use.
     |    * 'x'  : may contain hardcore sexual imagery or extremely disturbing violence.
     */

    'max-rating' => 'g',

];
