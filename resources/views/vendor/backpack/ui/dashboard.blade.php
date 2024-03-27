@extends(backpack_view('blank'))

@php

    //add div row using 'div' widget and make other widgets inside it to be in a row
    Widget::add()->to('before_content')->type('div')->class('row justify-content-center')->content([


        Widget::make()
            ->type('progress')
            ->class('card mb-3')
            ->statusBorder('start') // start|top|bottom
            ->accentColor('primary') // primary|secondary|warning|danger|info
            ->ribbon(['top', 'la-user-friends']) // ['top|right|bottom']
            ->progressClass('progress-bar')
            ->value($memberCount)
            ->description('Members.'),

        Widget::make()
            ->type('progress')
            ->class('card mb-3')
            ->statusBorder('start') // start|top|bottom
            ->accentColor('success') // primary|secondary|warning|danger|info
            ->ribbon(['top', 'la-check']) // ['top|right|bottom']
            ->progressClass('progress-bar')


            ->value($activeMembers)
            ->description('Active members.'),

        Widget::make()
            ->type('progress')
            ->class('card mb-3')
            ->statusBorder('start') // start|top|bottom
            ->accentColor('danger') // primary|secondary|warning|danger|info
            ->ribbon(['top', 'la-skull-crossbones']) // ['top|right|bottom']
            ->progressClass('progress-bar')
            ->value($expiredMembers)
            ->description('Expired members.'),
    ]);

    //you can also add Script & CSS to your page using 'script' & 'style' widget
    Widget::add()->type('script')->stack('after_scripts')->content('https://code.jquery.com/ui/1.12.0/jquery-ui.min.js');
    Widget::add()->type('style')->stack('after_styles')->content('https://cdn.jsdelivr.net/npm/@shoelace-style/shoelace@2.0.0-beta.58/dist/themes/light.css');

@endphp

@section('content')

@php

@endphp

@endsection
