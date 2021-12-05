## アプリ名

「ZeroFoodLoss」（ゼロフードロス）

## 概要

私の祖父母が営む個人商店で廃棄可能性のある食品を出品し、  
それを購入したいユーザーが予約できるサービスです。

## URL

https://zerofoodloss.herokuapp.com/

テストアカウント  
メール：test@test.com  
パスワード：password

## 作成背景

毎日のように廃棄食品が出て食べきず勿体ないため、近隣の人に安価で購入してもらうことにより、  
その問題を少しでも解決したいと考えたからです。

## 使用言語

* 言語
    * PHP
    * HTML
    * CSS
    * JavaScript

* フレームワーク
    * Laravel
    * Vue

## 工夫点

* 可読性
    * 自分が見た瞬間に何の機能かわかること、また他の人が見てもわかりやすいことを意識して、  
    コメントやインデントを入れました。

*  UI
    * スマートフォンで見ても崩れないUIになるよう実装しました。
    * いいね機能を非同期処理にして、ページ更新しなくてもいいね機能が動くようにしました。
    * 商品詳細ページで購入期限のカウントがゼロになると、ページ更新しなくても売り切れ表示へ変更されるようにしました。（DBの販売判別フラグは下記のスケジューラーで変更しています）

*  スケジューラー
    * 閉店時間になると、その日が購入期限であった商品の販売判別フラグが変更されるようにしました。

## 改善したい点と追加したい機能

・FatControllerの修正  
・商品予約後のキャンセル機能  
・商品のキーワード検索機能、カテゴリ別表示機能  
・管理者がユーザーからの予約を一括で確認できるページ  

## 利用方法

１．トップページから商品を選びます。  
<img width="500" alt="index" src="https://user-images.githubusercontent.com/87349101/144749182-f133c053-8b69-45d4-add5-eed21f066312.JPG">  

２．商品詳細画面で個数を選択し「カートに追加」ボタンを押します。  
<img width="500" alt="show" src="https://user-images.githubusercontent.com/87349101/144749190-abe7f254-ed29-4b9a-8482-a19f8bd51b8f.JPG">  

３．カート画面で内容を確認し「予約を確定する」ボタンを押します。  
<img width="500" alt="index" src="https://user-images.githubusercontent.com/87349101/144749191-6a5b6a76-3fbf-406a-9793-14128398027d.JPG">  

４．予約が確定され、予約番号が発行されます。  
また、登録メールアドレスに予約番号と内容の確認メールが届きます。  
<img width="500" alt="index" src="https://user-images.githubusercontent.com/87349101/144749192-6af9a937-ed47-4bae-85a9-e9f40dc03045.JPG">  
<img width="500" alt="index" src="https://user-images.githubusercontent.com/87349101/144749193-42292dbd-0fd5-4b06-9e48-3f1cb9d31d3d.JPG">  
