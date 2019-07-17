<?php get_header(); ?>

<div id="MapMain" class="gmap-main-wrapper">
  <div class="bg-green" style="height:300px">
    <div class="container"> 
      <h2 class="ttl-1 mt-xs-15 mb-xs-15"><span class="ttl-1-inner">Google Mapで検索</span></h2>
      <div id="mapArea" class="gmap-main bg-test mt-xs-5"></div>
      <script type="text/javascript" >
      // ロードしたタイミングで実行
      window.onload = function () {
        initMap();
      };
      var map;
      var marker = [];
      var infoWindow = [];
      var markerData = [
        {
          name: 'TAM 東京',
          lat: 35.6954806,
          lng: 139.76325010000005,
          icon: 'tam.png'
        },
        {
          name: '小川町駅',
          lat: 35.6951212,
          lng: 139.76610649999998
        },
        {
          name: '淡路町駅',
          lat: 35.69496,
          lng: 139.76746000000003
        },
        {
          name: '御茶ノ水駅',
          lat: 35.6993529,
          lng: 139.76526949999993
        },
        {
          name: '神保町駅',
          lat: 35.695932,
          lng: 139.75762699999996
        },
        {
          name: '新御茶ノ水駅',
          lat: 35.696932,
          lng: 139.76543200000003
        }
      ];
      function initMap() {
        // 地図の作成
        var mapLatLng = new google.maps.LatLng({lat: markerData[0]['lat'], lng: markerData[0]['lng']}); // 緯度経度のデータ作成
        map = new google.maps.Map(document.getElementById('mapArea'), { // #mapAreaに地図を埋め込む
          center: mapLatLng, // 地図の中心を指定
          zoom: 15 // 地図のズームを指定
        });
        // マーカー毎の処理
        for (var i = 0; i < markerData.length; i++) {
          markerLatLng = new google.maps.LatLng({lat: markerData[i]['lat'], lng: markerData[i]['lng']}); // 緯度経度のデータ作成
          console.log(markerLatLng); 
          marker[i] = new google.maps.Marker({ // マーカーの追加
            position: markerLatLng, // マーカーを立てる位置を指定
            map: map // マーカーを立てる地図を指定
          });
       
          infoWindow[i] = new google.maps.InfoWindow({ // 吹き出しの追加
            content: '<div class="mapArea">' + markerData[i]['name'] + '</div>' // 吹き出しに表示する内容
          });
          markerEvent(i); // マーカーにクリックイベントを追加
        }
       
        marker[0].setOptions({// TAM 東京のマーカーのオプション設定
          icon: {
            url: markerData[0]['icon']// マーカーの画像を変更
          }
        });
      }
      // マーカーにクリックイベントを追加
      function markerEvent(i) {
        marker[i].addListener('click', function() { // マーカーをクリックしたとき
          infoWindow[i].open(map, marker[i]); // 吹き出しの表示
        });
      }
      </script>
    </div>
  </div>
</div>

<section class="mt-xs-50">
  <div class="container">
    <h2 class="ttl-2">
      <i class="fas fa-map-marker-alt"></i> 
      ランドマーク一覧
      <span class="ttl-2-small">検索条件 : 城 / 日本の城 / 史跡</span>
    </h2>
    <ul class="row mt-xs-15">
      <li class="col-md-6 mt-xs-15">
        <div class="box-1 box-1-2col cf"> 
          <div class="box-1-inner cf">
            <div class="box-1-thumb matchHeight">
              <img src="https://placehold.jp/750x750.png" alt="">
            </div>
            <div class="box-1-main matchHeight">
              <div class="box-1-text">
                <h3 class="subttl-1">
                  大阪城 
                  <span class="subttl-1-mini">投稿日時 2018.10.14</span>
                </h3>
                <p class="mt-xs-5">大阪府大阪市中央区大阪城1-1</p>
                <ul class="taglist-1 cf mt-xs-10">
                  <li><a href="#">城・城址</a></li>
                  <li><a href="#">三大名城</a></li>
                  <li><a href="#">日本100名城</a></li>
                </ul>
              </div>
            </div>
            <div class="box-1-btn matchHeight">
              <div class="box-1-btnTop">
                <a href="#">
                  <span class="link-color-1">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/icon-pin.svg"> <span class="box-1-btnText">地図を見る</span>
                  </span>
                </a>
              </div>
              <div class="box-1-btnBottom">
                <a href="#">
                  <span class="link-color-1">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/icon-book.svg"> <span class="box-1-btnText">記事を読む</span>
                  </span>
                </a>
              </div>
            </div>
          </div>
          <div class="box-1-bottom">
            <ul class="taglist-1 cf mt-xs-10">
              <li><a href="#">城・城址</a></li>
              <li><a href="#">三大名城</a></li>
              <li><a href="#">日本100名城</a></li>
            </ul>
          </div>
        </div><!-- .box-1 -->
      </li>
      <li class="col-md-6 mt-xs-15">
        <div class="box-1 box-1-2col cf"> 
          <div class="box-1-inner cf">
            <div class="box-1-thumb matchHeight">
              <img src="https://placehold.jp/750x750.png" alt="">
            </div>
            <div class="box-1-main matchHeight">
              <div class="box-1-text">
                <h3 class="subttl-1">
                  大阪城 
                  <span class="subttl-1-mini">投稿日時 2018.10.14</span>
                </h3>
                <p class="mt-xs-5">大阪府大阪市中央区大阪城1-1</p>
                <ul class="taglist-1 cf mt-xs-10">
                  <li><a href="#">城・城址</a></li>
                  <li><a href="#">三大名城</a></li>
                  <li><a href="#">日本100名城</a></li>
                </ul>
              </div>
            </div>
            <div class="box-1-btn matchHeight">
              <div class="box-1-btnTop">
                <a href="#">
                  <span class="link-color-1">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/icon-pin.svg"> <span class="box-1-btnText">地図を見る</span>
                  </span>
                </a>
              </div>
              <div class="box-1-btnBottom">
                <a href="#">
                  <span class="link-color-1">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/icon-book.svg"> <span class="box-1-btnText">記事を読む</span>
                  </span>
                </a>
              </div>
            </div>
          </div>
          <div class="box-1-bottom">
            <ul class="taglist-1 cf mt-xs-10">
              <li><a href="#">城・城址</a></li>
              <li><a href="#">三大名城</a></li>
              <li><a href="#">日本100名城</a></li>
            </ul>
          </div>
        </div><!-- .box-1 -->
      </li>
      <li class="col-md-6 mt-xs-15">
        <div class="box-1 box-1-2col cf"> 
          <div class="box-1-inner cf">
            <div class="box-1-thumb matchHeight">
              <img src="https://placehold.jp/750x750.png" alt="">
            </div>
            <div class="box-1-main matchHeight">
              <div class="box-1-text">
                <h3 class="subttl-1">
                  大阪城 
                  <span class="subttl-1-mini">投稿日時 2018.10.14</span>
                </h3>
                <p class="mt-xs-5">大阪府大阪市中央区大阪城1-1</p>
                <ul class="taglist-1 cf mt-xs-10">
                  <li><a href="#">城・城址</a></li>
                  <li><a href="#">三大名城</a></li>
                  <li><a href="#">日本100名城</a></li>
                </ul>
              </div>
            </div>
            <div class="box-1-btn matchHeight">
              <div class="box-1-btnTop">
                <a href="#">
                  <span class="link-color-1">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/icon-pin.svg"> <span class="box-1-btnText">地図を見る</span>
                  </span>
                </a>
              </div>
              <div class="box-1-btnBottom">
                <a href="#">
                  <span class="link-color-1">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/icon-book.svg"> <span class="box-1-btnText">記事を読む</span>
                  </span>
                </a>
              </div>
            </div>
          </div>
          <div class="box-1-bottom">
            <ul class="taglist-1 cf mt-xs-10">
              <li><a href="#">城・城址</a></li>
              <li><a href="#">三大名城</a></li>
              <li><a href="#">日本100名城</a></li>
            </ul>
          </div>
        </div><!-- .box-1 -->
      </li>
      <li class="col-md-6 mt-xs-15">
        <div class="box-1 box-1-2col cf"> 
          <div class="box-1-inner cf">
            <div class="box-1-thumb matchHeight">
              <img src="https://placehold.jp/750x750.png" alt="">
            </div>
            <div class="box-1-main matchHeight">
              <div class="box-1-text">
                <h3 class="subttl-1">
                  大阪城 
                  <span class="subttl-1-mini">投稿日時 2018.10.14</span>
                </h3>
                <p class="mt-xs-5">大阪府大阪市中央区大阪城1-1</p>
                <ul class="taglist-1 cf mt-xs-10">
                  <li><a href="#">城・城址</a></li>
                  <li><a href="#">三大名城</a></li>
                  <li><a href="#">日本100名城</a></li>
                </ul>
              </div>
            </div>
            <div class="box-1-btn matchHeight">
              <div class="box-1-btnTop">
                <a href="#">
                  <span class="link-color-1">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/icon-pin.svg"> <span class="box-1-btnText">地図を見る</span>
                  </span>
                </a>
              </div>
              <div class="box-1-btnBottom">
                <a href="#">
                  <span class="link-color-1">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/icon-book.svg"> <span class="box-1-btnText">記事を読む</span>
                  </span>
                </a>
              </div>
            </div>
          </div>
          <div class="box-1-bottom">
            <ul class="taglist-1 cf mt-xs-10">
              <li><a href="#">城・城址</a></li>
              <li><a href="#">三大名城</a></li>
              <li><a href="#">日本100名城</a></li>
            </ul>
          </div>
        </div><!-- .box-1 -->
      </li>
    </ul>
  </div>
</section>


<section class="mt-xs-50 bg-img-1 pb-xs-50 bt-s pt-xs-50">
  <div class="container">
    <h2 class="ttl-3">
      <span class="ttl-3-sub">今月の特集テーマ</span>
      <span class="ttl-3-main mml-char">『2018年NHK大河ドラマ「西郷どん」ゆかりの地を行く』</span>
    </h2>
    <div id="mapArea2" class="gmap-main mt-xs-15" style="height:500px;"></div>
    <p class="text-normal mt-xs-30">
      薩摩の貧しい下級藩士の家の長男として生まれた西郷隆盛。家のため、お金のために役人の元で働き始めます。しかし、情深い西郷は困った人のために身を削り自分の金や食べ物も与えてしまいます。そんな彼に家族たちも困り果てますが、本人はお構いなし。<br>
      そんな他人に優しい西郷に、藩主の島津斉彬が目を留めます。西郷自身も「民の幸せこそが国を富ませ強くする」という信念を持つ島津に惹かれます。島津から預けられた密命を受けて、東から西まで駆け回ります。だんだんと知名度を上げることとなり、重要人物と認識されるまでになります。 [...記事の詳細へ]
    </p>
    <ul class="row mt-xs-30">
      <li class="col-md-4 matchHeight">
        <div class="box-2">
          <h3 class="box-2-subttl">
            <span class="box-2-subttl-num">1</span>
            <span class="box-2-subttl-main">西郷隆盛誕生地碑</span>
          </h3>
          <div class="box-2-main">
            <div class="box-2-main-inner">
              <div class="box-2-main-thumb">
                <img src="https://placehold.jp/100x100.png" alt="">
              </div>
              <div class="box-2-main-text">
                <p>
                西郷吉之助は、鹿児島城(鶴丸城)<br>
                下の下級武士が住む加治屋町にて生まれました。
                西郷隆盛の妹・西郷琴などの兄弟もここで生まれました。
                </p>
              </div>
            </div>
          </div>
        </div>
      </li>
      <li class="col-md-4 matchHeight">
        <div class="box-2">
          <h3 class="box-2-subttl">
            <span class="box-2-subttl-num">2</span>
            <span class="box-2-subttl-main">西郷隆盛誕生地碑</span>
          </h3>
          <div class="box-2-main">
            <div class="box-2-main-inner">
              <div class="box-2-main-thumb">
                <img src="https://placehold.jp/100x100.png" alt="">
              </div>
              <div class="box-2-main-text">
                <p>
                西郷吉之助は、鹿児島城(鶴丸城)<br>
                下の下級武士が住む加治屋町にて生まれました。
                西郷隆盛の妹・西郷琴などの兄弟もここで生まれました。
                </p>
              </div>
            </div>
          </div>
        </div>
      </li>
      <li class="col-md-4 matchHeight">
        <div class="box-2">
          <h3 class="box-2-subttl">
            <span class="box-2-subttl-num">3</span>
            <span class="box-2-subttl-main">西郷隆盛誕生地碑</span>
          </h3>
          <div class="box-2-main">
            <div class="box-2-main-inner">
              <div class="box-2-main-thumb">
                <img src="https://placehold.jp/100x100.png" alt="">
              </div>
              <div class="box-2-main-text">
                <p>
                西郷吉之助は、鹿児島城(鶴丸城)<br>
                下の下級武士が住む加治屋町にて生まれました。
                西郷隆盛の妹・西郷琴などの兄弟もここで生まれました。
                </p>
              </div>
            </div>
          </div>
        </div>
      </li>
    </ul>
  </div>
</section>

<?php get_template_part('parts/tab-content'); ?>

<?php get_footer(); ?>