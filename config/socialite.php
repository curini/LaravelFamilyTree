<?php

return [
    'redirect' => [
        'success' => env('SOCIALITE_REDIRECT_SUCCESS', '/'),
        'error' => env('SOCIALITE_REDIRECT_ERROR', '/login'),
    ],
    'css' => [
        'button' => env('SOCIALITE_CSS_BUTTON', 'gap-2 rounded-full p-2 text-sm leading-5 text-white bg-zinc-500 hover:bg-zinc-700'),
        'img' => env('SOCIALITE_CSS_IMG', 'inline-block'),
    ],
    'text' => env('SOCIALITE_GITHUB_TEXT', 'Sign in with GitHub'),
    'img' => env('SOCIALITE_GITHUB_IMG', 'https://d1mj7kpaxms69g.cloudfront.net/assets/github_logo_light-5473d144f61893d30a58ba3f4fee4ece8d4b6425bb1f00d7f856b3d65d04ab9d.svg')
];
