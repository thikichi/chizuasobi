
gulp sass

監視
gulp sass:watch
ctrl + c で中止

/* 一定パターンのCSSを量産する */
/* 一定間隔でモジュールを作成する例 */
@for $i from 0 through 30 {
  .mt-#{$i * 5} {
    margin-top: #{$i * 5}px;
  }
}
例）mt-50

cd C:\xampp\htdocs\development\wp-tpl2\wp-content\themes\os-wp-theme\css\sass


コンパイルモード
nested / compact / expanded / compressed

test
