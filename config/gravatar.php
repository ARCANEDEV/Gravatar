<?php

// For more details: https://en.gravatar.com/site/implement/images/

return [
    /* ------------------------------------------------------------------------------------------------
     |  Default
     | ------------------------------------------------------------------------------------------------
     |  The default avatar to display if we have no results (you can also set a default image url).
     |
     |  Supported:
     |    * false
     |    * '404'
     |    * 'mm'        : (mystery-man) a simple, cartoon-style silhouetted outline of a person (does not vary by email hash).
     |    * 'identicon' : a geometric pattern based on an email hash.
     |    * 'monsterid' : a generated 'monster' with different colors, faces, etc.
     |    * 'wavatar'   : generated faces with differing features and backgrounds.
     |    * 'retro'     : awesome generated, 8-bit arcade-style pixelated faces.
     */
    'default' => 'identicon',

    /* ------------------------------------------------------------------------------------------------
     |  Size
     | ------------------------------------------------------------------------------------------------
     |  The default avatar size.
     */
    'size' => 80,

    /* ------------------------------------------------------------------------------------------------
     |  Rating
     | ------------------------------------------------------------------------------------------------
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
