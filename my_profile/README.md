# My Profile by yii2

自己紹介・ポートフォリオ・SNSアカウント・フレンドコード共有SNS

# About
このアプリケーションは人々の所有しているウェブサイトや各種SNSのURLはもとより、自己紹介ページや各種ポートフォリオ、アプリのフレンドコード等を一括登録し、このサービスで表示させ、自己紹介ページを提示するだけで自分のプロフィールやポートフォリオ、各種SNSアカウント、フレンドコードを他の人にアピールできます。  
例えばTwitter(X)ではプロフィールにリンクは一つしか掲載できませんよね？
もしあなたがウェブサイトやYoutubeチャンネル、ニコニコ動画、facebook、Qiita、Linkedin、Pixiv等複数のSNSを有していたり、複数のアプリのフレンドコードを有しているとして、それらを全て登録することは出来ません。  
しかし、このサービスにそれら全てのURLを登録し、自己紹介ページのURLを各種SNSのURL欄にこのサービスの自己紹介ページやアプリのフレンドコードを登録すれば一括して観てもらうことが出来ます。  

# Install
まず、あなたのサーバーのウェブルートにこのプロジェクトをcloneして下さい。  
(webサーバ、PHP、MySQLまたはmaria db。composerの準備をお忘れなく！)  
次にインストールディレクトリで次のコマンドを打ちます。
```angular2html
composer install
composer update
```
MySQLまたはmaria dbで任意の名前のデータベースを作成します。  
DB名とDBユーザー名、DBユーザーのパスワード、DBのホスト情報(localhostまたはipアドレスまたはドメイン名)  を控えておいて下さい。  
config/db.phpを開き、DB名、DBユーザー名、DBユーザーのパスワード、DBのホスト情報を記入します。  
ターミナルでmysqlまたはmaria dbに入り
```use 作成したDB名```
を実行後、インストールディレクトリ直下にあるyii2_my_profile.sqlに記載されたSQL文を実行して下さい。
# 設定ファイルの書き換えとgoogle認証設定・paypal決済設定
## パスワードリマインダーや問い合わせフォームで使うメールの設定(gmail)

gmailのアカウントを取得し、gmailのアプリパスワードを発行しconfig/web.phpとconfig/params.phpに設定します。    
発行方法はこちらをご覧下さい。  
https://support.google.com/mail/answer/185833?hl=ja  
web.phpとparams.phpにメールアドレスとアプリパスワードを設定する方法は  
https://qiita.com/Fu3nori/items/0d602634ae0592581ce6  
を御覧ください  
  
## googleソーシャルログイン認証設定
ソーシャルログインの設定手順  
googleアカウントを作る  
google cloudコンソール　https://console.cloud.google.com/welcome  　
にアクセス    
左側のハンバーガーメニューからIAMを選択  
ドロップダウンリストをクリックし新しいプロジェクトを選択  
プロジェクト名を入力して作成、ここではMyProfileRelease  
IAM画面に戻ってくるのでドロップダウンリストでMyProfileReleaseを選択  
プロジェクト「MyProfileRelease」の権限が表示されているので使用しているメールアドレスにロール・オーナーが割当てられていることを確認  
左側のハンバーガーメニューからAPIとサービスを選択  
OAuth同意画面を選択  
Externalを選択して作成  
アプリ名にMyProfileReleaseと入力  
ユーザーサポートメールのドロップダウンリストでIAMで登録したメールアドレスを選択  
アプリのロゴに120px*120px以内のサイズの画像ファイルをアップロード  
アプリのドメインでアプリケーションのホームページにはhttps://www.ドメイン名/アプリ設置ディレクトリ/web  
と入力　
※httpdのURL設定で～/webをウェブルートディレクトリにしていたのならhttps://www.ドメイン名/アプリ設置ディレクトリ/  
で良い  
デモアプリのホームページ（トップページ）はhttps://my-profile.biz/web/　
なのでそのとおりにいれる。  
アプリケーション・プライバシーポリシーリンクは、Aboutページにプライバシーポリシーを記入するので  
https://ドメイン名/設置ディレクトリ/web/site/about   
とする。  
デモアプリの場合はhttps://my-profile.biz/web/site/about　
となる    
アプリケーション利用規約リンクはAboutページに利用規約を記入するので  
https://ドメイン名/設置ディレクトリ/web/site/about  
とする。  
デモアプリの場合はhttps://my-profile.biz/web/site/about　
となる  
承認済みドメインにはドメインの追加を押してアプリを設置するサーバーのドメイン ex foovar.comなどをいれる  
デモアプリのドメインはmy-profile.bizなのでその通りにいれる  
デベロッパーの連絡先情報には今回取得したgoogleアカウントのメールアドレスを入れる。  
保存して次へをクリック  
スコープを追加または削除をクリック  
Googleアカウントのメインのメールアドレスの参照、ユーザーの個人情報の表示、  
Googleで公開されているお客様の個人情報とお客様を関連付ける、の項目にチェックを入れる  
画面下の更新をクリック  
スコープ画面に戻ってくるので画面下の保存して次へをクリック  
テストユーザーを聞かれるが、ここは無視して画面下の保存して次へをクリック  
OAuth consent screenと表示されるので画面下のBACK TO DASHBOARDをクリック  
Publishing statusと表示され、ステータスはTesting(前の画面で登録したテストユーザーしか  
ソーシャル・ログインできない)になっているので、下のPUBLISH APPをクリック  
ダイアログが出るので確認をクリック、Publishing statusがIn productionになっていればOK  
左側のメニューから認証情報をクリック  
認証情報を作成をクリック  
OAuthクライアントIDをクリック※  
※この時、左上のドロップダウンリストが作成したアプリ名になっていることを確認すること  
アプリケーションの種類をドロップダウンリストからウェブ アプリケーションを選択  
名前はアプリと同じ名前にしておくと良い。ここではMyProfileReleaseとする  
承認済みのJavaScript生成元でURIを追加をクリック、  
https://www.アプリを設置したサーバーのドメイン:443　と入力※  
※ドメインの後に/は入れないこと、httpsではなくhttpの場合は:443ではなく:80とすること  
承認済みのリダイレクト URIでURIを追加をクリック  
ソーシャル・ログインした後、認証処理を行うURLをポート番号込みで入力する  
URLはhttps://アプリを設置したサーバーのドメイン:443/アプリを設置したディレクトリ/web/user/auth  
となる  
デモアプリの場合  
https://my-profile.biz/web/user/auth  
が認証処理を行うURLなので  
https://my-profile.biz:443/web/user/auth 
となる  
最後に作成をクリック  
クライアントIDとクライアントシークレットが表示されるのでメモを取る。
アプリの　config/web.phpを開く  
```config/web.php

	'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'google' => [
                    'class' => 'yii\authclient\clients\Google',
                    'clientId' => 'CLIENT ID',
                    'clientSecret' => 'CLIENT SECRET',
                    'returnUrl' => '認証処理を行うURL',
                    'scope' => 'email profile',
                ],
            ],
        ],
```
と記述されている箇所があるのでclientIDにはメモをしたクライアントID  
clientSecretにはメモをしたクライアントシークレットを割り当て  
returnUrlには承認済みのリダイレクト URI（デモアプリならhttps://my-profile.biz:443/web/user/auth）  
を割り当てる  
  
## Paypalの設定、clientIdとclientSecretの発行と設定とwebhook urlの設定
新しいメールアドレスを用意しpaypalビジネスアカウント公式ページにアクセス  
https://www.paypal.com/jp/webapps/mpp/merchant/member  
新規登録を行い、本人確認を画面指示に従って行います。  
アカウントが発行されたらログインし、画面右上のデベロッパーをクリックします。  
https://developer.paypal.com/dashboard/  
に遷移します。  
My Apps & Credentialsをクリックして画面右上のトグルスイッチをLive(本番)にします。  
次にCreateAppをクリックしてアプリ名入力欄にわかりやすいアプリ名を入れます。  
デモアプリではmy-profileとしています  
create appをクリックします。  
App nameとClient IDとSecret key 1が表示されるのでメモします。  
画面下のAccept paymentsで全てのチェックボックスにチェックを入れます  
Save Changesをクリックします。  
https://developer.paypal.com/dashboard/applications/live  　
に移動します。  
App name欄に先ほど入力したアプリ名があるのを確認してクリックします。  
画面の一番下にAdd Webhookボタン(決済情報を受信するURLの設定)があるので  
クリックします。  
Webhookの入力欄が出てくるので  
https://www.アプリを設置したサーバーのドメイン/アプリの設置ディレクトリ/web/site/webhook  
と入力します。  
デモアプリの場合は  
https://my-profile.biz/web/site/webhook  
となりますので読み替えて下さい。  
  
Event typesにはAll Eventsにチェックを入れて下さい。  
画面下のSaveをクリックします。  
  
config/web.phpを開きます。paypalの項目を参照し以下のように記載します。  
``
'paypal' => [
'class' => 'app\components\PaypalComponent',
'clientId' => 'paypalで発行したclientIdを書き込む',
'clientSecret' => 'paypalで発行したclientSecretを書き込む',
'sandbox' => false, // 本番環境ではfalseに設定
],
``
views/layouts/main.phpを開きます。javascriptSDKのクエリーを以下の通り書き換えます。  
28行目の  
https://www.paypal.com/sdk/js?client-id=PAYPALで発行したclientId&currency=JPY  
&currency=JPYといれることで日本円での計算になります。  
  
views/site/index.phpを開きます。  
100行目にvalue: '1500', // 支払い金額（日本円）と書いてるので任意の値段に設定します。  
  
  
  
# 管理者アカウント発行
次に "https://www.インストールしたサーバーのドメイン/インストールディレクトリ/web/user/regist" 
にアクセスし、アカウントを登録して下さい。    
※この時一番最初に登録したユーザーが管理人となり、userテーブルのroleの値が1=管理人となります。   
アカウント名とメールアドレスはよく考えて下さい。それ以降に発行されたユーザーアカウントは一般ユーザーでroleは0になります。  
※URLに/web/が入るのが嫌な方はwebサーバーのエイリアスなどで対応して下さい。  
   
※コンタクトフォームのメール送信機能について  
このアプリケーションはYii2フレームワークで作られておりデフォルトでコンタクトフォームが用意されていますが受信する管理人のメールアドレスとそのメールアドレスにメールを飛ばすメールサーバーの設定が必要です。    
https://qiita.com/Fu3nori/items/0d602634ae0592581ce6 
のコンタクトフォームの設定 の項目をご覧下さい。  　　
  
  
# 出来ること
ユーザーはダッシュボードから自己紹介ページを作り、それ以降は常に編集できます。    
自己紹介ページには自分のウェブサイトや会社のウェブサイト、SNSのURLからアプリのフレンドコードまで自由に登録できます。    
自己紹介シェアページを参照すると登録された自己紹介が表示され、URLのコピーやURLのTwitter(X)シェアが出来ます。   
また、QRコードも表示されますのでそれでシェアも可能です。  
管理人はそれ以外にもユーザー一覧ページを参照しそこから自由にユーザーを閲覧・編集できます。  
ユーザーはpaypalで課金するとユーザーロールが3になり、自己紹介ページに5枚まで画像をアップロードできます
