<?php
include_once('inc.php');
$fpage = 1;
$re = "select title,description,meta_title,meta_description,meta_keyword from post_list where type='menu' and id='2'";
$re2 = mysqli_query($conn, $re) or die(mysqli_error($conn));
$post_result = mysqli_fetch_array($re2);

$privacypage = 1;
?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
    <title><?php echo stripslashes($post_result['meta_title']); ?></title>
    <meta name="description" content="<?php echo stripslashes($post_result['meta_description']); ?>" />
    <meta name="keywords" content="<?php echo stripslashes($post_result['meta_keyword']); ?>" />

    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <script src="js/jquery.min.js"></script>


</head>

<body style="background-image:none;">
    <div class="aboutheader">
        <div class="container">
            <div class="logo">
                <a style="margin-top:0px; margin-bottom:0px;" href="<?php echo $fullurl; ?>"><img
                        src="images/sdglogo.png" style="width: 275px;" /></a>
            </div>
            <?php if (isset($_SESSION['sessUserId']) && $_SESSION["sessUserId"] != '' && $_SESSION["sessUserId"] != 0) { ?>
                <div class="toggle hiden-xs" onclick="$('.setting_menu').toggle();">
                    <a href="javascript:void(0);">
                        <span class="usr_img"><img
                                src="<?php echo $fullurl; ?>uploads/<?php echo $myprofilePhoto; ?>"></span>
                    </a>
                    <ul class="setting_menu" style="display: none;">
                        <li><a href="<?php echo $fullurl; ?>"><i class="fa fa-cog" aria-hidden="true"></i> Go to
                                timeline</a></li>
                    </ul>
                </div>
            <?php } ?>
        </div>
    </div>

    <div class="help-banner">
        <p>Privacy</p>
    </div>
    <span class="clear"></span>
    <div class="container">
        <div class="helpwrap-cont">
            <?php include('sdg_left_link.php'); ?>
            <div class="right-panel">
                <p><strong>Privacy Policy Notice</strong></p>

                <p>Our Privacy Policy explains how SDG COMNET VECOSPACE collects, uses, and discloses
                    information about you.
                    The terms &ldquo;SDG COMNET VECOSPACE,&rdquo; &ldquo;we,&rdquo; &ldquo;us,&rdquo; and
                    &ldquo;our&rdquo;
                    include SDG COMNET VECOSPACE, Inc. and our affiliates. We use the terms
                    &ldquo;member,&rdquo;
                    &ldquo;you,&rdquo; and &ldquo;your&rdquo; to mean any person using our Platform or attending related
                    events, including any organization or person using the Platform on an organization&rsquo;s behalf.
                </p>

                <p>This Privacy Policy applies to the processing of information about members and other individuals that
                    we collect when you use our &ldquo;Platform,&rdquo; which means any website, application, or
                    services we offer, or when you communicate with us.</p>

                <p>For information about choices that we offer under this policy, please see &ldquo;Your Choices&rdquo;
                    below. This Privacy Policy does not apply to the information that you may provide to third parties,
                    such as members, and others with whom you may share information about yourself.</p>

                <p><strong>Collection of Information</strong></p>

                <p>1.1<strong>Information You Provide to Us</strong></p>

                <p>We collect information that you provide directly to us. For example, we collect information that you
                    provide when you create an account, choose interests or groups, fill out a form, or communicate with
                    us.</p>

                <p>The types of information that we may collect include your name, username, password, email address,
                    postal address, phone number, payment method data, photos, choices of interests and groups, and any
                    other information that you choose to provide.</p>

                <p>&nbsp;Information about your gender and interests is optional. Your choice of groups is optional, but
                    we are required to process this information to administer your account, and to indicate that you are
                    a member of the groups that you join.</p>

                <p>On occasion, the information that you give us when you join a group may imply information about your
                    beliefs, political views, health conditions; or your sexual identity. This, and other kinds of
                    sensitive information, is given special protection. Posting personal or sensitive information about
                    yourself or others is against our <a
                        href="https://meetup.zendesk.com/hc/sections/360000683791-Community-Guidelines">Community
                        Guidelines</a>.</p>

                <p>&nbsp;</p>

                <ol>
                    <li><strong>Information We Collect Automatically When You Use the Platform</strong></li>
                </ol>

                <p>When you use our Platform, we automatically collect information about you, including:</p>

                <ul>
                    <li><strong>Log Information:</strong>We collect log information about your use of the Platform,
                        including the type of browser that you use; the time, duration and frequency of your access;
                        Platform pages viewed; your IP address; and the page you visited before visiting our Platform.
                    </li>
                </ul>

                <p style="margin-left:43.1pt">&nbsp;</p>

                <ul>
                    <li><strong>Device Information:</strong>We collect information about the computer or mobile device
                        that you use to access our Platform, including the hardware model, operating system and version,
                        unique device identifiers, and mobile network information.</li>
                </ul>

                <p>&nbsp;</p>

                <p style="margin-left:43.1pt">&nbsp;</p>

                <ul>
                    <li><strong>Location Information</strong>: We may collect information about the location of your
                        device each time you use our Platform based on your consent to the collection of this
                        information. For further information see<a
                            href="https://www.meetup.com/privacy/#section5.2">Section 5.2</a>.</li>
                </ul>

                <p style="margin-left:43.1pt">&nbsp;</p>

                <ul>
                    <li><strong>Information Collected by Cookies and Other Tracking Technologies</strong>:</li>
                </ul>

                <p style="margin-left:43.1pt">We and our service providers collect information using various
                    technologies, including cookies and pixel tags (which are also called clear GIFs, web beacons, or
                    pixels).</p>

                <p style="margin-left:43.1pt">Cookies are small data files stored on your hard drive or in device memory
                    that help us improve our Platform and your experience, and track usage of our Platform.</p>

                <p style="margin-left:43.1pt">&nbsp;</p>

                <p style="margin-left:43.1pt">Pixel tags are electronic images that may be used in our Platform or
                    emails, and track usage of our Platform and effectiveness of communications. You can learn more
                    about the types of cookies we and our service providers use by reading our <a
                        href="https://www.meetup.com/cookie_policy/">Cookie Policy</a>.</p>

                <p style="margin-left:43.1pt">&nbsp;</p>

                <ul>
                    <li><strong>Other Information</strong>: With your permission, we may collect other information from
                        your device, such as photos from your camera roll, contacts of individuals you wish to find or
                        connect with, or calendar information you want to manage via the Platform.</li>
                </ul>

                <p style="margin-left:46.35pt">&nbsp;</p>

                <ol>
                    <li><strong>Information We Collect from Other Sources</strong></li>
                </ol>

                <p style="margin-left:18.0pt">We may collect information about you from other sources, such as through
                    certain features on the Platform you elect to use, but only where these third parties either have
                    your consent or are otherwise legally permitted or required to disclose your information to us.
                    Examples include -:</p>

                <p style="margin-left:53.45pt">&nbsp;</p>

                <p style="margin-left:53.45pt">&nbsp;</p>

                <ul>
                    <li><strong>Invitations</strong>-:If another member sends you an invitation through our Platform, we
                        may receive certain personal information, such as your name, email address, or phone number. If
                        you are an invited guest, we will automatically send you an invitation to our Platform, and, if
                        unanswered, a one-time follow-up invitation.</li>
                </ul>

                <p style="margin-left:53.45pt">&nbsp;</p>

                <p style="margin-left:53.45pt">SDG COMNET VECOSPACE stores this contact information only to
                    send these
                    invitations and evaluate their success. You may unsubscribe from future invitations using the
                    instructions in those messages. You may also contact us at privacy VECOSPACE.com to request that we
                    remove this information from our database.</p>

                <p style="margin-left:53.45pt">&nbsp;</p>

                <ul>
                    <li><strong>MemberContent -</strong>: We may receive information about you when you or another
                        member uploadphoto or posts other content to the Platform. For further details about the rights
                        over this information available to individuals.</li>
                    <li><strong>Information from Other Third-Party Sources-</strong>:&nbsp; In order to provide you with
                        more tailored recommendations, we may obtain information about you from publicly and
                        commercially available sources and other third parties as permitted by law. For more information
                        about the data that we obtain from these providers, please contact us at privacy@SGT
                        VECOSPACE.com.</li>
                </ul>

                <p>&nbsp;</p>

                <p>&nbsp;</p>

                <p>2. <strong>Use of Information </strong></p>

                <p>2.1<strong>Operating our Platform</strong></p>

                <p><strong>We may use information about you for various purposes related to operating our Platform,
                        including to:</strong></p>

                <ol>
                    <li>Provide, maintain, and improve our Platform, including to process transactions, develop new
                        products and services, and manage the performance of our Platform;</li>
                    <li>Display information about you, for instance, your list of interests, which will be visible on
                        your profile;</li>
                    <li>Personalize the Platform, for example, to suggest content in which we think you may be
                        interested (including content given special protection under EU law or that relates to sensitive
                        topics such as health, political opinions, religion, and sexual identity);</li>
                    <li>Provide you with better recommendations;</li>
                    <li>Monitor and analyse trends, usage, and activities in connection with our Platform; and</li>
                    <li>Detect, investigate, and prevent fraudulent transactions, abuse, and other illegal activities;
                        to protect the rights, property, or safety of SDG COMNET VECOSPACE and others; to
                        enforce compliance
                        with our policies; and to comply with applicable law and government requests.</li>
                    <li>Perform accounting and administrative tasks and enforce or manage legal claims.</li>
                </ol>

                <p>2.2<strong>Communicatingwith You</strong></p>

                <p><strong>We may use information about you for various purposes related to communicating with you,
                        including to:</strong></p>

                <ol>
                    <li>Respond to your comments, questions, and requests, and provide customer service;</li>
                    <li>Communicate with you, in accordance with your account settings, about products, services, and
                        events offered by us and others, to provide news and information that we think will be of
                        interest to you, to conduct online surveys, to contact you about events on our Platform that are
                        being held near your location, and to otherwise communicate with you in accordance with Section
                        2.3;</li>
                    <li>Notify you about communications of other members, in accordance with the communication
                        preferences that you indicate in your account; and</li>
                    <li>Send you technical notices, updates, security alerts and support, and administrative messages.
                    </li>
                </ol>

                <p>2.3<strong>Advertising and Other Uses</strong></p>

                <p><strong>We may use information about you for various other purposes, including to:</strong></p>

                <ol>
                    <li>Provide content, features, or sponsorships that match member profiles or interests;</li>
                    <li>Facilitate contests and other promotions;</li>
                    <li>Combine with information that we collect for the purposes described in this Privacy Policy; and
                    </li>
                    <li>Carry out any other purposes described to you at the time that we collected the information.
                    </li>
                </ol>

                <p>2.4 <strong>Legal Basis for Processing</strong></p>

                <p><strong>Our legal basis for collecting and using the information described above will depend on the
                        type of information and the specific context in which we collect it.</strong></p>

                <ol>
                    <li>We process information about you to provide our services in accordance with our <a
                            href="https://www.meetup.com/terms/">Terms of Service</a>, for example to allow you to join
                        groups, or to display your profile to other members, and to allow us to send you important
                        service updates.</li>
                    <li>We also process information about you where it is in our legitimate interests to do so and not
                        overridden by your rights (for example, in some cases for direct marketing, fraud prevention,
                        network and information systems security, responding to your communications, the operation of
                        networks of groups by the network administrators, and improving our Platform).</li>
                    <li>Sometimes you provide us with sensitive information about you; for instance, the mere fact of
                        joining a certain group may indicate information about your health, religion, political views,
                        or sexual identity. Joining such groups or posting information on the Platform about these
                        topics is entirely voluntarily and done with your explicit consent.</li>
                    <li>In some cases, we may also have a legal obligation to collect information about you or may
                        otherwise need the information to protect your vital interests or those of another person.</li>
                    <li>We may also process information to comply with a legal requirement or to perform a contract.
                    </li>
                </ol>

                <p>3.<strong> Sharing of Information</strong></p>

                <p>3.1<strong>Through Our Platform</strong></p>

                <p>We share some of the information that we collect by displaying it on our Platform according to your
                    member profile and account settings. Some information, such as user name, is always public. Some
                    information, such as interests, is public by default, but can be hidden on our Platform. Some
                    information, such as group memberships, will always be visible to other members of that SGT
                    VECOSPACE group, and may be public, depending on the settings of that group.</p>

                <p>We recommend that you check the group settings and what information will be available before joining
                    the group to ensure that you are happy with the information that is visible to others.</p>

                <p>3.2<strong>Group Networks</strong></p>

                <p>If you are a member of a group, this group may now or in the future become part of a network of
                    groups known as a &ldquo;SDG COMNET VECOSPACE Pro&rdquo; network. Members who administer a
                    SDG COMNET VECOSPACE
                    Pro network, known as &ldquo;network administrators&rdquo; have access to the content within their
                    groups.</p>

                <p>Network administrators find it helpful to have access to the email addresses of organizers and other
                    members of groups within their networks, to easily communicate with and administer the groups.
                    Therefore, we may ask if you want to share your email address with your group&rsquo;s network
                    administrator.</p>

                <p>3.3 <strong>WeWork Locations</strong></p>

                <p>3.4<strong>With Our Service Providers</strong></p>

                <p>We may use service providers in connection with operating and improving the Platform to assist with
                    certain functions, such as payment processing, email transmission, conducting surveys or contests,
                    data hosting, managing our ads, and some aspects of our technical and customer support. We take
                    measures to ensure that these service providers access, process, and store information about you
                    only for the purposes we authorize, subject to confidentiality obligations.</p>

                <p>3.5<strong>Following the Law and Protecting SDG COMNET VECOSPACE</strong></p>

                <p>We may access, preserve, and disclose information about you to third parties, including the content
                    of messages, if we believe disclosure is in accordance with, or required by, applicable law,
                    regulation, legal process, or audits. We may also disclose information about you if we believe that
                    your actions are inconsistent with our <a href="https://www.meetup.com/terms/">Terms of Service</a>
                    or related guidelines and policies, or if necessary to protect the rights, property, or safety of,
                    or prevent fraud or abuse of, SDG COMNET VECOSPACE or others.</p>

                <p>3.6<strong>Sharing and Other Tools</strong></p>

                <p>The Platform may offer sharing features and other integrated tools which let you share activities
                    that you take on our Platform with third-party services, and vice versa. Such features let you share
                    information with your contacts, depending on the settings you have chosen with the service.</p>

                <p>The third-party services&#39; use of the information will be governed by the third-parties&rsquo;
                    privacy policies, and we do not control the third-parties&rsquo; use of the shared data. For more
                    information about the purpose and scope of data collection and processing in connection with social
                    sharing features, please review the privacy policies of the services that provide these features.
                </p>

                <p>3.7 <strong>Affiliate Sharing and Merger, Sale, Or Other Asset Transfers</strong></p>

                <p>If SDG COMNET VECOSPACE is involved in a merger, acquisition, financing, reorganization,
                    bankruptcy, or sale
                    of our assets, information about you may be shared, sold, or transferred as part of that
                    transaction. We may also share information about you with current or future corporate parents,
                    subsidiaries, or affiliates.</p>

                <p>3.8<strong>Other Situations</strong></p>

                <p>We may de-identify or aggregate information about you and share it freely, so that you can no longer
                    be identified. We may also share information about you with your consent or at your direction or
                    where we are legally entitled to do so.</p>

                <p>&nbsp;</p>

                <p>4.<strong>Additional Information</strong></p>

                <p>4.1<strong>Analytics and Advertising Services Provided by Others</strong></p>

                <p>With your permission, we may allow others to use cookies, web beacons, device identifiers, and other
                    technologies to collect information about your use of the Platform and other websites and online
                    services. See our<a href="https://www.meetup.com/cookie_policy/">Cookie Policy</a>for details about
                    these technologies and the information that they collect, use, or share, including how you may be
                    able to control or disable these services.</p>

                <p>4.2<strong>Security</strong></p>

                <p>We employ technical and organizational measures designed to appropriately protect your information
                    that is under our control and that we process on your behalf from unauthorized access collection,
                    use, disclosure, copying, modification or disposal, both during transmission and once we receive it.
                    We store all information that you provide to us on secure servers.</p>

                <p>&nbsp;We train employees regarding our data privacy policies and procedures and permit authorized
                    employees to access information on a need to know basis, as required for their role. We use
                    firewalls designed to protect against intruders and test for network vulnerabilities. However, no
                    method of transmission over the internet or method of electronic storage is completely secure.</p>

                <p>Where you have a password, which enables you to use our services, you are responsible for keeping
                    this password complex, secure, and confidential. If you would like to update or change your
                    password, you may select the &ldquo;Forgot your password?&rdquo; link on the login page. You will be
                    sent an email that allows you to reset your password.</p>

                <p>4.3<strong>Data Retention</strong></p>

                <p>We may temporarily block your account if you have not logged in for six months or more. You may
                    contact us if you wish to reactivate your account.We retain certain information that we collect from
                    you while you are a member of the Platform, and in certain cases where you have deleted your
                    account, for the following reasons:</p>

                <ul>
                    <li>You can use our Platform;</li>
                    <li>To ensure that we do not communicate with you if you have asked us not to;</li>
                    <li>To provide you with a refund, if entitled;</li>
                    <li>To provide accurate accounting information to other members about the groups that they organize
                        or administer, and associated memberships;</li>
                    <li>To better understand the traffic to our Platform so that we can provide all members with the
                        best possible experience;</li>
                    <li>To detect and prevent abuse of our Platform, illegal activities and breaches of our Terms of
                        Service; and</li>
                    <li>To comply with applicable legal, tax or accounting requirements.</li>
                </ul>

                <p>When we have no ongoing legitimate business need to process your information, we will either delete
                    or anonymize it.</p>

                <p>&nbsp;</p>

                <p>4.4<strong>Policy Scope</strong></p>

                <p>This Privacy Policy does not apply to information that you provide to third parties, such as other
                    members, including group organizers and network administrators, and others with whom you may share
                    information about you. Our Platform may direct you to a third-party service, such as social media
                    services, or a portion of our Platform may be controlled by a third party (typically using a frame
                    or pop-up window separate from other content on our Platform).</p>

                <p>Disclosure of information to these third parties is subject to the relevant third party&rsquo;s
                    privacy policy. We are not responsible for the third-party privacy policy or content, even if we
                    link to those services from our Platform or if we share information with these third parties.</p>

                <p>&nbsp;Members, including group organizers and network administrators, are directly responsible for
                    complying with all requirements of applicable privacy laws as per their country in connection with
                    the information that they obtain and process for the purposes of managing their contacts, or
                    organizing groups, or administering networks</p>

                <p>4.5<strong>Revisions to This Policy</strong></p>

                <p>We may modify this Privacy Policy from time to time. When we do, we will provide notice to you by
                    publishing the most current version and revising the date at the top of this page. If we make any
                    material change to this policy, we will provide additional notice to you, such as by sending you an
                    email or displaying a prominent notice on our Platform.</p>

                <p>5. <strong>Your Choices</strong></p>

                <p>5.1<strong>Your Choices: Account Information</strong></p>

                <p>You may update or correct your account information by editing your account settings or by sending a
                    request to privacy@SDG COMNET VECOSPACE.com as described inYou may deactivate your account
                    by editing your
                    account settings or by sending an email to privacy@NDIMVECOSPACE.com. You will also
                    be able to choose
                    what information others see about you and who may contact you by using the Privacy Settings section
                    in your Account.</p>

                <p>5.2<strong>Your Choices: Location Information</strong></p>

                <p>&nbsp;</p>

                <p>When you first access the Platform, we will collect information about your location, which we use to
                    make better recommendations for groups and events in your area, and to improve our Platform. If you
                    do not want us to collect information about your location, then you can prevent this:</p>

                <ul>
                    <li>If using a mobile app, by changing the settings on your device.</li>
                    <li>If using our website, your location data will be obtained via a cookie. Please refer to our <a
                            href="https://www.meetup.com/cookie_policy/">Cookie Policy</a>for additional information on
                        how to manage our use of cookies.</li>
                </ul>

                <p><strong>Note that our Platform or its features may no longer function properly if you do.</strong>
                </p>

                <p>Your mobile device settings may also give you the option to choose whether to allow us to view your
                    location on a continuous basis, when only using the app, or never. Allowing us to view your location
                    when you are not using the app allows us to provide you with recommendations on a regular basis.
                    Please refer to your device&rsquo;s guide for additional information on how to adjust location
                    services.</p>

                <p>5.3 <strong>Your Choices: Cookies</strong></p>

                <p>We may use and allow others to use cookies, web beacons, device identifiers, and other technologies
                    to collect information about your use of the Platform and other websites and online services. See
                    our<a href="https://www.meetup.com/cookie_policy/">Cookie Policy</a>for details about these
                    technologies and the information that they collect, use, or share, including how you may be able to
                    control or disable these services.</p>

                <p>5.4<strong>Your Choices: Promotional Communications</strong></p>

                <p>You can control messages that you receive from SDG COMNET VECOSPACE, other members, and
                    third parties by
                    selecting the unsubscribe link in the message that you receive, or by adjusting the communication
                    preferences in your account settings.</p>

                <p>We will also send you a link to these settings when you first sign up and in subsequent messages. If
                    you opt out, we may still send you non-promotional messages, such as those about your account or our
                    ongoing business relations.</p>

                <p>6.<strong>Data Rights<a name="_GoBack"></a></strong></p>

                <p>We respond to all requests that we receive from individuals who wish to exercise their data
                    protection rights in accordance with applicable data protection laws. You can contact us by sending
                    an email to privacy@SDG COMNET VECOSPACE.com.</p>

                <p><strong>Rights that you may have, depending on the country in which you live, include:</strong></p>

                <ul>
                    <li><strong>Accessing, correcting, updating, or requesting</strong> deletion of your information.
                    </li>
                    <li><strong>Objecting to processing</strong> of your information, asking us to restrict processing
                        of your information, or requesting the portability of your information.</li>
                    <li><strong>Opting out from receiving marketing communications</strong> that we send you at any
                        time. You can exercise this right by selecting the &ldquo;unsubscribe&rdquo; or
                        &ldquo;opt-out&rdquo; link in the marketing emails we send you. Additionally, you may update
                        your email preferences by changing the settings in your account.</li>
                    <li><strong>Withdrawing your consent </strong>at any time if we have collected and processed your
                        information with your consent. Withdrawing your consent will not affect the lawfulness of any
                        processing that we conducted prior to your withdrawal, nor will it affect processing of your
                        information conducted in reliance on lawful processing grounds other than consent.</li>
                    <li><strong>Complaining to a data protection authority</strong> about our collection and use of your
                        information. For more information, please contact your local data protection authority. Contact
                        details for data protection authorities in the Indian Subcontinent are available <a
                            href="http://ec.europa.eu/justice/data-protection/article-29/structure/data-protection-authorities/index_en.htm">here</a>.
                    </li>
                </ul>

                <p>&nbsp;Other members, such as group organizers and network administrators, may also act as controllers
                    of your information. You should contact these members if you have any questions about how they use
                    information that you have provided to them.</p>

                <p><strong>7. Contact Us</strong></p>

                <p>Under Indian Subcontinent data protection law, the controller of your information is SDG COMNET
                    VECOSPACE,
                    Inc.If you have any questions or complaints about this Privacy Policy or how we use your
                    information, please contact privacy@SDG COMNET VECOSPACE.com.</p>

                <p>&nbsp;</p>

            </div>
        </div>
    </div>
    </div>
    <?php include('backtotop.php'); ?>
</body>

</html>