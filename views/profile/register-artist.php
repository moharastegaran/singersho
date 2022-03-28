<?php

global $user;
global $is_user_artist;
if ($is_user_artist) : ?>
    <script> const pathSplit = window.location.pathname.split("/");
        window.location.href = pathSplit[pathSplit.length-1]; </script>
<?php endif; ?>
<?php

$register_artist = callAPI('PUT', RAW_API . 'artist/register', false, true);
$register_artist = json_decode($register_artist,true);
$is_artist = $register_artist['error'];
if (! $is_artist) : ?>
<script> const pathSplit = window.location.pathname.split("/");
        window.location.href = pathSplit[pathSplit.length-1]; </script>
<?php endif; ?>
