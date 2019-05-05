jQuery(function($) {

  /* font-size によっては別アイコンが表示されるバグに対応 */

  $('.demo-icon').text('');

  /* コピペ用コード生成 */

  $('.i-name').each(function() {
    var text = $(this).text();
    $(this)
    .text('<i class="' + text + '"></i>')
    .addClass('selectable');
  });

  /* テスト用（前） */

  // $('.demo-icon').each(function() {
  //   $(this)
  //   .before('日本語のテストです')
  //   .css({
  //     margin: 0
  //   });
  // });

  // $('.i-name').each(function() {
  //   $(this)
  //   .text('');
  // });

  /* テスト用（後） */

  // $('.demo-icon').each(function() {
  //   $(this)
  //   .css({
  //     margin: 0
  //   });
  // });

  // $('.i-name').each(function() {
  //   $(this)
  //   .text('日本語のテストです')
  //   .css({
  //     display: 'inline',
  //     float: 'none',
  //   });
  // });

  /* CSS用コード生成 */

  $('.i-code').addClass('selectable');

  $('.i-code').each(function() {
    var code = $(this).text();
    code = code.replace(/^0x/, '\\');
    $(this).text(code);
  });

  /* selectable */

  $('body').on('click', '.selectable', function() {

    var range;
    var selection;

    range = document.createRange(); /* 該当箇所を含むセルを取得 */
    range.selectNodeContents(this); /* 該当箇所を選択 */

    selection = window.getSelection(); /* カーソルによる選択範囲を取得 */
    selection.removeAllRanges(); /* カーソルによる選択範囲を解除 for IE */

    selection.addRange(range);

  });

  /* show codes 生成 */

  var switchInput = $('.switch input');
  $('.switch').html(switchInput).append('CSS用コード');

  /* font-size 生成 */

  $('.switch').after('<div class=size><label class="size-label" for="size-number">font-size <input class=size-number type=number id="size-number" value=14> <input class=size-range type=range value=14 max=100 min=10 step=1></label></div>');

  /* description 生成 */

  // $.ajax('demo.inc',{
  //   dataType: 'html'
  // }).then(function(data){
  //   $('#icons').prepend(data);
  // });

  $('#icons').prepend('<div class="description description-caution description-headline">このページに上がっているものが最新版ですが、実際に使用する際は、案件の子テーマに入っている<br>fonts/fontello/demo.html<br>をブラウザで開き、そこで表示されるこれと同じようなページから、コピペして使います。<br>Fontelloは随時更新されますが、制作中の案件にそれを反映させるのはNGです。反映させたい場合は要相談。</div><div class=description><ul class=descripton-list><li><span class=description-headline>CSSで使うには</span><ol class=description-list-sub><li>画面右上の「CSS用コード」をチェック<li>各アイコン右のHTMLがCSS用コードに変わります<li>表示されたCSS用コードで下記の例のように記述します（クリックで全選択）<br><pre class="description-pre selectable">.class::before {\n  font-family: \'fontello\';\n  content: \'\e800\';\n}</pre><br>※以前は font-family: \'fontello-custom\'; でしたので、その時代のものを使用している案件には fontello-custom と記述します。</ol></ul></div><div class=description><ul class=descripton-list><li><span class=description-headline>OSFW以外のWordPressで使えるようにするには</span><ol class=description-list-sub><li>fontello-custom を <a download href=fontello-custom.zip>ダウンロード</a><li>fontello-custom を fonts/ に入れます<li>functions.php に 右記コードを記述します（クリックで全選択）<br><pre class="description-pre selectable">add_action(\'wp_enqueue_scripts\', function() {\n  wp_enqueue_style(\'fontello-custom\', get_stylesheet_directory_uri().\'/fonts/fontello-custom/css/fontello.css\');\n});</pre><li>あとはコピペするだけで使えます</ol></ul></div><div class=description><ul class=descripton-list><li><span class=description-headline>デザインで使うには</span><ol class=description-list-sub><li>svg を <a download href=fontello-custom-svg.zip>ダウンロード</a></ol></ul></div>')

  /* font-size on change */

  $('.size input').on('change', function() {
    var size = $(this).val();
    $('.size input').val(size);
    $('.demo-icon').css({
      fontSize: size + 'px'
    });
  });

  /* 見出し生成 */

  var original = $('#icons').html();
  $('#icons').html(original.replace(/      <\/div>\n      <div class="row">\n/g, ''));

  $('[class*="arrow1"]:first').parent().before('<h2 class="category">矢印</h2>');
  $('[class*="cancel1"]:first').parent().before('<h2 class="category">×印・閉じる・キャンセル</h2>');
  $('[class*="check1"]:first').parent().before('<h2 class="category">チェック</h2>');
  $('[class*="minus1"]:first').parent().before('<h2 class="category">マイナス</h2>');
  $('[class*="plus1"]:first').parent().before('<h2 class="category">プラス</h2>');
  $('[class*="search1"]:first').parent().before('<h2 class="category">検索</h2>');
  $('[class*="tel1"]:first').parent().before('<h2 class="category">電話（受話器）</h2>');
  $('[class*="tel2"]:first').parent().before('<h2 class="category">電話（プッシュ）</h2>');
  $('[class*="tel3"]:first').parent().before('<h2 class="category">電話（ダイアル）</h2>');
  $('[class*="tel4"]:first').parent().before('<h2 class="category">電話（スマホ）</h2>');
  $('[class*="fax1"]:first').parent().before('<h2 class="category">FAX・印刷・プリンター</h2>');
  $('[class*="map1"]:first').parent().before('<h2 class="category">マップ・地図</h2>');
  $('[class*="mail1"]:first').parent().before('<h2 class="category">メール</h2>');
  $('[class*="sns"]:first').parent().before('<h2 class="category">SNS</h2>');
  $('[class*="medical1"]:first').parent().before('<h2 class="category">医療・病院・薬局</h2>');
  $('[class*="zoom1"]:first').parent().before('<h2 class="category">拡大・ズーム</h2>');
  $('[class*="calendar1"]:first').parent().before('<h2 class="category">カレンダー</h2>');
  $('[class*="pdf1"]:first').parent().before('<h2 class="category">PDF</h2>');
  $('[class*="speaker1"]:first').parent().before('<h2 class="category">メガホン・拡声器・お知らせ</h2>');
  $('[class*="home1"]:first').parent().before('<h2 class="category">ホーム・家</h2>');
  $('[class*="building1"]:first').parent().before('<h2 class="category">ビル・建物</h2>');
  $('[class*="cart1"]:first').parent().before('<h2 class="category">ショッピングカート</h2>');
  $('[class*="circle1"]:first').parent().before('<h2 class="category">ドット</h2>');
  $('[class*="youtube1"]:first').parent().before('<h2 class="category">YouTube</h2>');
  $('[class*="movie1"]:first').parent().before('<h2 class="category">動画</h2>');
  $('[class*="quote1"]:first').parent().before('<h2 class="category">引用符</h2>');
  $('[class*="book1"]:first').parent().before('<h2 class="category">本</h2>');

});
