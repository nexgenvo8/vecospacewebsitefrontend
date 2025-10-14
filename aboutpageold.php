<?php
include_once('inc.php');
$fpage = 1;
$re = "select title,description,meta_title,meta_description,meta_keyword from post_list  where id='6'";
$re2 = mysqli_query($conn, $re) or die(mysqli_error($conn));
$post_result = mysqli_fetch_array($re2);
?>
<!DOCTYPE html>
<html>

<head>
  <title><?php echo stripslashes($post_result['meta_title']); ?></title>
  <meta name="description" content="<?php echo stripslashes($post_result['meta_description']); ?>" />
  <meta name="keywords" content="<?php echo stripslashes($post_result['meta_keyword']); ?>" />
  <link rel="icon" href="<?php echo $fullurl; ?>favicon.ico" type="image/x-icon">
  <link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/responsive.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
  <link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
  <script src="<?php echo $fullurl; ?>js/jquery.min.js"></script>
  <script src="<?php echo $fullurl; ?>js/main.js"></script>
</head>

<body>
  <div id="wrapper" class="active">
    <?php include('header.php'); ?>
    <div class="container main">

      <div class="home_container">
        <div class="center_content nologin">
          <div class="about-us">
            <h1 class="heading-line">Greetings and a warm welcome to <font color="#39a8d7">Konectt</font> <br> a
              networking platform for
              Knowledge, Career and Business Growth.</h1>
            <ul class="mision-box-list">
              <li>
                <div class="mission-box">
                  <h2>Vision</h2>
                  <p>We aim to bring a positive change in the professional and personal lives of
                    people and enable them to become more informed, inspired and successful.</p>
                </div>
              </li>
              <li>
                <div class="mission-box">
                  <h2>Mission</h2>
                  <p>To become a one-stop digital platform enabling individuals and organizations
                    to consume and share relevant information and collaborate towards self,
                    career and business growth.</p>
                </div>
              </li>
            </ul>
            <div class="whowe-r">
              <h1 class="heading-line">Who are we?</h1>
              <p>Konectt is owned and operated by OMSR Media Pvt Limited, a company
                incorporated in India under the Companies Act, 2013. OMSR Media also
                publishes the portal <a href="www.theknowledgegateway.com"
                  target="_blank">www.theknowledgegateway.com.</a> </p>
              <p>At Konectt, our objective is single minded…to continually innovate our
                platform and provide the individuals, small and big businesses and other key
                stake holders of a nation, an opportunity to create a meaningful dialogue or
                establish a fruitful association towards sustained growth.</p>
              <p>We once again welcome you to our platform and look forward to your
                patronage.</p>
            </div>

            <div class="our-team">
              <h2>The Team at Konectt</h2>
              <div class="team-mmbr-cont">
                <div class="team-mmbr">
                  <div class="mmbr-name"><b>Tarun Grover</b> Founder and Chief Growth Officer</div>
                  <div class="teammmbr-dtail">

                    <div class="team-descript">
                      <ul>
                        <li>Tarun has over 15 years of experience in managing and growing businesses and teams across
                          offline and digital platforms. He has launched products, conceptualized and executed large
                          scale business events and also started (with zero capital) his own venture, which he later
                          successfully closed with zero liability in the books.</li>
                        <li>In his professional stint, he got the opportunity to meet and interact with global thought
                          leaders including Prof. Philip Kotler, Prof. Clayton Christensen, Prof. Gary Hamel, Deepak
                          Chopra and many others.</li>
                        <li>While with Times of India in his last role, Tarun was managing, along with his team, a
                          business of over 30 crore in revenue, across digital platforms.</li>
                        <li>Being part of the largest and most diversified media group, had the opportunity to closely
                          align and understand the tech and product development side of the digital business.</li>
                      </ul>
                    </div>
                    <div class="timg">
                      <img src="<?php echo $fullurl; ?>images/tarun.jpg">
                    </div>
                  </div>
                </div>
              </div>
              <div class="team-mmbr-cont">
                <div class="team-mmbr">
                  <div class="mmbr-name"><b>Deepak Grover</b> Director and Chief Strategist</div>
                  <div class="teammmbr-dtail">
                    <div class="team-descript">
                      <ul>
                        <li>Deepak is seasoned industry professional with over 20 years of global experience. Deepak
                          has gained invaluable business expertise both in India and international markets. Besides
                          India he has had the opportunity to work in international locations like UK, Holland and
                          Switzerland in leadership roles with global corporations.</li>
                        <li>Deepak&#39;s key strength is creating strategic plans and sustainable business models. He
                          has
                          created extraordinary business from scratch by leveraging the resources available and
                          developing P&amp;Ls units that have high potential to grow.</li>

                      </ul>
                    </div>
                    <div class="timg">
                      <img src="<?php echo $fullurl; ?>images/deepak.jpg">
                    </div>
                  </div>
                </div>
              </div>
            </div>




          </div>
        </div>
      </div>
    </div>
    <?php include('footer.php'); ?>
  </div>
</body>

</html>