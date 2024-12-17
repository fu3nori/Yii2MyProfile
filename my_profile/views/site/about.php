<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1 class="display-5"><?= Html::encode($this->title) ?></h1>
    <div class="heading-underline mb-4"></div>

    <h2 class="display-6">イントロダクション</h2>
    <div class="heading-underline mb-3"></div>
    <p>
        My Profileへようこそ。<br>このサービスはあなたの所有しているウェブサイトや各種SNSのURLはもとより、自己紹介ページや各種ポートフォリオ、アプリ・ゲームのフレンドコードを一括登録し、このサービスで表示される自己紹介ページを提示するだけで自分のプロフィールやポートフォリオ、各種SNSアカウントを他の人にアピールできます。<br>
        例えばTwitter(X)ではプロフィールにリンクは一つしか掲載できませんよね？<br>もしあなたがウェブサイトやYoutubeチャンネル、ニコニコ動画、facebook、Qiita、Linkedin、Pixiv等複数のSNSを有しているとして、それらを全て登録することは出来ません。<br>
        しかし、このサービスにそれら全てのURLやゲーム・アプリのフレンドコードを登録し、このサービスの自己紹介ページをシェアすれば一括して観てもらうことが出来ます。<br>
        まずはプロフィール登録ページにアクセスし、あなたが所有するウェブサイトのURLや各種SNSのURL、自己紹介文やポートフォリオを、ゲーム・アプリのフレンドコードを登録・掲載し、自己紹介表示ページのURLをSNSのURL登録欄に登録しましょう。<br>
        自己紹介表示ページのURLはページに用意されたTwitter(X)シェアボタンやQRコードでシェアできます。
    </p>

    <h2 class="display-6">利用規約</h2>
    <div class="heading-underline mb-3"></div>
    <ul>
        <li>あなたは自由に自己紹介ページにURLとその説明を登録できます</li>
        <li>掲載するURLに違法なサイトまたは公序良俗に反するサイトを使うことは出来ません</li>
        <li>自己紹介文に違法な情報や犯罪の教唆、スパム文章、他者を誹謗中傷する文章を入力する事は禁じられています</li>
        <li>前述の禁止された行為が発覚した場合、管理者は該当ユーザーのアカウントを通告なしに停止する事があります</li>
        <li>このサイトに登録された個人情報は法的機関からの開示請求がない限り開示しません</li>
        <li>このサービスを通じて発生したトラブルについては管理人は一切責任を負いません</li>
        <li>この規約はサービスのユーザーアカウントを取得した時点で同意したものと見なします</li>
    </ul>
</div>

<style>
    .display-5 {
        font-size: 2.5rem;
    }
    .display-6 {
        font-size: 2rem;
    }
    .heading-underline {
        border-bottom: 2px solid #007BFF;
        width: 50px;
    }
</style>
