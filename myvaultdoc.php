<?php
include_once('inc.php');
$page = 2;
$totalSpace = 1024;

?>
<!DOCTYPE html>
<html>

<head>
    <title>Vault - <?php echo $companNameTitle; ?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/responsive.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/smallnav.css">
    <link rel="icon" href="<?php echo $fullurl; ?>favicon.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <script src="<?php echo $fullurl; ?>js/jquery.min.js"></script>
    <script src="<?php echo $fullurl; ?>js/main.js"></script>


</head>

<body>
    <div id="wrapper">
        <?php include('header.php'); ?>
        <div class="container main">
            <div class="home_container">
                <?php include('left-sidebar.php'); ?>
                <div class="center_content <?php if ($_SESSION["sessUserId"] != '' && $_SESSION["sessUserId"] != 0) {
                } else {
                    echo 'nologin';
                } ?>">
                    <div class="bx-shadow">
                        <?php include('vaultinc.php'); ?>
                        <div class="your-vault">
                            <div class="my-doclist">
                                <h2>My Documents</h2>
                                <ul class="vault-box-4">
                                    <?php
                                    $a = "";
                                    $n = 0;
                                    $totalFileSize = 0; // ✅ initialize variable
                                    
                                    $a = mysqli_query($conn, "SELECT * FROM " . _VAULT_MASTER_TABLE_ . " WHERE userId='" . $_SESSION['sessUserId'] . "' AND name!='' ORDER BY id DESC");

                                    $totaldocuments = mysqli_num_rows($a);

                                    if ($totaldocuments > 0) {
                                        while ($rowpendingfile = mysqli_fetch_array($a)) {
                                            $totalFileSize += trim($rowpendingfile["fileSize"]);

                                            ?>
                                            <div class="file-uploded" style="margin:10px; width:97%;">
                                                <div class="uploded-wrap">
                                                    <div class="publish-doc">
                                                        <a
                                                            href="<?php echo $fullurl; ?>view-document.html?id=<?php echo encodeStr($rowpendingfile["id"]); ?>"><img
                                                                src="<?php echo $fullurl; ?><?php if (file_exists('uploads/' . $rowpendingfile["documentFile"] . '.jpg')) { ?>uploads/<?php echo $rowpendingfile["documentFile"] . '.jpg';
                                                                   } else {
                                                                       $strFileExtention = findExtension($rowpendingfile["documentFile"]); ?>images/<?php if ($strFileExtention == 'doc') {
                                                                              echo 'doc.png';
                                                                          }
                                                                          if ($strFileExtention == 'xls') {
                                                                              echo 'xls.png';
                                                                          }
                                                                          if ($strFileExtention == 'ppt') {
                                                                              echo 'ppt.png';
                                                                          }
                                                                          if ($strFileExtention == 'pdf') {
                                                                              echo 'pdf.png';
                                                                          }
                                                                   } ?>" width="100%" height="100%"></a>
                                                    </div>
                                                    <!--<?php if ($rowpendingfile["privacy"] == 1) { ?><div class="privacy-tag">Public</div><?php } else { ?><div class="privacy-tag" style=" background-color:#f4bc2d;">Private</div><?php } ?>-->
                                                    <div class="published-rightdtail">
                                                        <a href="<?php echo $fullurl; ?>view-document.html?id=<?php echo encodeStr($rowpendingfile["id"]); ?>"
                                                            class="nm"><?php echo stripslashes(cleanquestionmark($rowpendingfile["name"])); ?></a>
                                                        <div class="desc">
                                                            <?php echo getStrLength(strip_tags(stripslashes(cleanquestionmark($rowpendingfile["longDescription"]))), 150); ?>
                                                        </div>
                                                        <label
                                                            class="time"><?php echo makedatetime($rowpendingfile["dateAdded"]); ?></label>
                                                        <!--<label class="time" style="margin-top:20px;"><a href="<?php echo $fullurl; ?>upload-documents.html?id=<?php echo encodeStr($rowpendingfile["id"]); ?>">Edit Document</a></label>-->
                                                        <?php if ($rowpendingfile["privacy"] == 1) { ?>
                                                            <div class="privacy-tag">Public</div><?php } else { ?>
                                                            <div class="privacy-tag" style=" background-color:#f4bc2d;">Private
                                                            </div><?php } ?>
                                                        <ul class="hover-btn">
                                                            <li><a class="edit"
                                                                    href="<?php echo $fullurl; ?>upload-documents.html?id=<?php echo encodeStr($rowpendingfile["id"]); ?>"><i
                                                                        class="fa fa-pencil" aria-hidden="true"></i>&nbsp;</a>
                                                            </li>
                                                            <li style="display:none;"><a href="#" class="dlt"><i
                                                                        class="fa fa-trash-o" aria-hidden="true"></i>&nbsp;</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            $n++;
                                        }

                                        $actualtotalFileSize = ceil($totalFileSize / 1024 / 1024 / $totalSpace * 100);
                                        $usedtotalFileSize = ceil($totalFileSize / 1024 / 1024);
                                        $totalRemainingFileSize = ceil($totalSpace - $usedtotalFileSize);

                                    }

                                    ?>
                                </ul>

                                <?php if ($n == 0) { ?>
                                    <div style="padding:20px; text-align:center;">There is no documents currently to
                                        display.</div>
                                <?php } ?>
                            </div>
                            <div class="storage-graph" style="display:none;">
                                <h2>Used Server Space</h2>
                                <div class="usd-graph">
                                    <div class="chart" data-arrow="up" data-size="100"
                                        data-value="<?php echo $actualtotalFileSize; ?>">&nbsp;</div>

                                </div>
                                <script type="text/javascript">

                                    var Dial = function (container) {
                                        this.container = container;
                                        this.size = this.container.dataset.size;
                                        this.strokeWidth = this.size / 8;
                                        this.radius = (this.size / 2) - (this.strokeWidth / 2);
                                        this.value = this.container.dataset.value;
                                        this.direction = this.container.dataset.arrow;
                                        this.svg;
                                        this.defs;
                                        this.slice;
                                        this.overlay;
                                        this.text;
                                        this.arrow;
                                        this.create();
                                    }

                                    Dial.prototype.create = function () {
                                        this.createSvg();
                                        this.createDefs();
                                        this.createSlice();
                                        this.createOverlay();
                                        this.createText();
                                        this.createArrow();
                                        this.container.appendChild(this.svg);
                                    };

                                    Dial.prototype.createSvg = function () {
                                        var svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
                                        svg.setAttribute('width', this.size + 'px');
                                        svg.setAttribute('height', this.size + 'px');
                                        this.svg = svg;
                                    };

                                    Dial.prototype.createDefs = function () {
                                        var defs = document.createElementNS("http://www.w3.org/2000/svg", "defs");
                                        var linearGradient = document.createElementNS("http://www.w3.org/2000/svg", "linearGradient");
                                        linearGradient.setAttribute('id', 'gradient');
                                        var stop1 = document.createElementNS("http://www.w3.org/2000/svg", "stop");
                                        stop1.setAttribute('stop-color', '#6E4AE2');
                                        stop1.setAttribute('offset', '0%');
                                        linearGradient.appendChild(stop1);
                                        var stop2 = document.createElementNS("http://www.w3.org/2000/svg", "stop");
                                        stop2.setAttribute('stop-color', '#78F8EC');
                                        stop2.setAttribute('offset', '100%');
                                        linearGradient.appendChild(stop2);
                                        var linearGradientBackground = document.createElementNS("http://www.w3.org/2000/svg", "linearGradient");
                                        linearGradientBackground.setAttribute('id', 'gradient-background');
                                        var stop1 = document.createElementNS("http://www.w3.org/2000/svg", "stop");
                                        stop1.setAttribute('stop-color', 'rgba(0, 0, 0, 0.2)');
                                        stop1.setAttribute('offset', '0%');
                                        linearGradientBackground.appendChild(stop1);
                                        var stop2 = document.createElementNS("http://www.w3.org/2000/svg", "stop");
                                        stop2.setAttribute('stop-color', 'rgba(0, 0, 0, 0.05)');
                                        stop2.setAttribute('offset', '100%');
                                        linearGradientBackground.appendChild(stop2);
                                        defs.appendChild(linearGradient);
                                        defs.appendChild(linearGradientBackground);
                                        this.svg.appendChild(defs);
                                        this.defs = defs;
                                    };

                                    Dial.prototype.createSlice = function () {
                                        var slice = document.createElementNS("http://www.w3.org/2000/svg", "path");
                                        slice.setAttribute('fill', 'none');
                                        slice.setAttribute('stroke', '#e94436');
                                        slice.setAttribute('stroke-width', this.strokeWidth);
                                        slice.setAttribute('transform', 'translate(' + this.strokeWidth / 2 + ',' + this.strokeWidth / 2 + ')');
                                        slice.setAttribute('class', 'animate-draw');
                                        this.svg.appendChild(slice);
                                        this.slice = slice;
                                    };

                                    Dial.prototype.createOverlay = function () {
                                        var r = this.size - (this.size / 2) - this.strokeWidth / 2;
                                        var circle = document.createElementNS("http://www.w3.org/2000/svg", "circle");
                                        circle.setAttribute('cx', this.size / 2);
                                        circle.setAttribute('cy', this.size / 2);
                                        circle.setAttribute('r', r);
                                        circle.setAttribute('fill', '#3294c3');
                                        this.svg.appendChild(circle);
                                        this.overlay = circle;
                                    };

                                    Dial.prototype.createText = function () {
                                        var fontSize = this.size / 3.5;
                                        var text = document.createElementNS("http://www.w3.org/2000/svg", "text");
                                        text.setAttribute('x', (this.size / 2) + fontSize / 7.5);
                                        text.setAttribute('y', (this.size / 2) + fontSize / 4);
                                        text.setAttribute('font-family', 'Century Gothic, Lato');
                                        text.setAttribute('font-size', fontSize);
                                        text.setAttribute('fill', '#fff');
                                        text.setAttribute('text-anchor', 'middle');
                                        var tspanSize = fontSize / 3;
                                        text.innerHTML = 0 + '<tspan font-size="' + tspanSize + '" dy="' + -tspanSize * 2 + '">%</tspan>';
                                        this.svg.appendChild(text);
                                        this.text = text;
                                    };

                                    Dial.prototype.createArrow = function () {
                                        var arrowSize = this.size / 10;
                                        var arrowYOffset, m;
                                        if (this.direction === 'up') {
                                            arrowYOffset = arrowSize / 2;
                                            m = -1;
                                        }
                                        else if (this.direction === 'down') {
                                            arrowYOffset = 0;
                                            m = 1;
                                        }
                                        var arrowPosX = ((this.size / 2) - arrowSize / 2);
                                        var arrowPosY = (this.size - this.size / 3) + arrowYOffset;
                                        var arrowDOffset = m * (arrowSize / 1.5);
                                        var arrow = document.createElementNS("http://www.w3.org/2000/svg", "path");
                                        arrow.setAttribute('d', 'M 0 0 ' + arrowSize + ' 0 ' + arrowSize / 2 + ' ' + arrowDOffset + ' 0 0 Z');
                                        arrow.setAttribute('fill', '#fff');
                                        arrow.setAttribute('opacity', '0.6');
                                        arrow.setAttribute('transform', 'translate(' + arrowPosX + ',' + arrowPosY + ')');
                                        this.svg.appendChild(arrow);
                                        this.arrow = arrow;
                                    };

                                    Dial.prototype.animateStart = function () {
                                        var v = 0;
                                        var self = this;
                                        var intervalOne = setInterval(function () {
                                            var p = +(v / self.value).toFixed(2);
                                            var a = (p < 0.95) ? 2 - (2 * p) : 0.05;
                                            v += a;
                                            // Stop
                                            if (v >= +self.value) {
                                                v = self.value;
                                                clearInterval(intervalOne);
                                            }
                                            self.setValue(v);
                                        }, 10);
                                    };

                                    Dial.prototype.animateReset = function () {
                                        this.setValue(0);
                                    };

                                    Dial.prototype.polarToCartesian = function (centerX, centerY, radius, angleInDegrees) {
                                        var angleInRadians = (angleInDegrees - 90) * Math.PI / 180.0;
                                        return {
                                            x: centerX + (radius * Math.cos(angleInRadians)),
                                            y: centerY + (radius * Math.sin(angleInRadians))
                                        };
                                    }

                                    Dial.prototype.describeArc = function (x, y, radius, startAngle, endAngle) {
                                        var start = this.polarToCartesian(x, y, radius, endAngle);
                                        var end = this.polarToCartesian(x, y, radius, startAngle);
                                        var largeArcFlag = endAngle - startAngle <= 180 ? "0" : "1";
                                        var d = [
                                            "M", start.x, start.y,
                                            "A", radius, radius, 0, largeArcFlag, 0, end.x, end.y
                                        ].join(" ");
                                        return d;
                                    }

                                    Dial.prototype.setValue = function (value) {
                                        var c = (value / 100) * 360;
                                        if (c === 360)
                                            c = 359.99;
                                        var xy = this.size / 2 - this.strokeWidth / 2;
                                        var d = this.describeArc(xy, xy, xy, 180, 180 + c);
                                        this.slice.setAttribute('d', d);
                                        var tspanSize = (this.size / 3.5) / 3;
                                        this.text.innerHTML = Math.floor(value) + '<tspan font-size="' + tspanSize + '" dy="' + -tspanSize * 1.2 + '">%</tspan>';
                                    };

                                    //
                                    // Usage
                                    //

                                    var containers = document.getElementsByClassName("chart");
                                    var dial = new Dial(containers[0]);
                                    dial.animateStart();
                                </script>
                                <ul class="spce-used">
                                    <li>Total Space: <span><?php echo $totalSpace; ?> MB</span></li>
                                    <li>Used Space:
                                        <span><?php if ($usedtotalFileSize != '') {
                                            echo $usedtotalFileSize;
                                        } else {
                                            echo '0';
                                        } ?>
                                            MB</span>
                                    </li>
                                    <li>Remaining Space:
                                        <span><?php if ($totalRemainingFileSize != '') {
                                            echo $totalRemainingFileSize;
                                        } else {
                                            echo $totalSpace;
                                        } ?>
                                            MB</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div> <!-- [End center content] -->
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