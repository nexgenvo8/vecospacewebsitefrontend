<?php
include_once('inc.php');
$fpage = 2;
$re = "select title,description,meta_title,meta_description,meta_keyword from post_list  where id='3'";
$re2 = mysqli_query($conn, $re) or die(mysqli_error($conn));
$post_result = mysqli_fetch_array($re2);
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

  <style>
    .helpwrap-cont .right-panel ul {
      list-style: disc;
      padding-left: 25px;
    }
  </style>
</head>

<body style="background-image:none;">
  <div class="aboutheader">
    <div class="container">
      <div class="logo">
        <a style="margin-top:0px; margin-bottom:0px;" href="<?php echo $fullurl; ?>"><img src="images/ndimlogo.png"
            style="width: 275px;" /></a>
      </div>
      <?php if ($_SESSION["sessUserId"] != '' && $_SESSION["sessUserId"] != 0) { ?>
        <div class="toggle hiden-xs" onclick="$('.setting_menu').toggle();">
          <a href="javascript:void(0);">
            <span class="usr_img"><img src="<?php echo $fullurl; ?>uploads/<?php echo $myprofilePhoto; ?>"></span>
          </a>
          <ul class="setting_menu" style="display: none;">
            <li><a href="<?php echo $fullurl; ?>"><i class="fa fa-cog" aria-hidden="true"></i> Go to timeline</a></li>
          </ul>
        </div>
      <?php } ?>
    </div>
  </div>

  <div class="help-banner">
    <p><?php echo stripslashes($post_result['title']); ?></p>
  </div>
  <span class="clear"></span>
  <div class="container">
    <div class="helpwrap-cont">
      <?php include('ndim_left_links.php'); ?>
      <div class="right-panel">
<p><strong>Terms of Service Overview</strong></p>

<p>Below is an overview of our <a href="https://www.meetup.com/terms/#terms">Terms of Service</a> for our &ldquo;Platform&rdquo;, which means any website, application, or service we offer. You should read the complete Terms of Service because that document (and not this overview) is our legally binding agreement. The Terms of Service includes information about your legal rights and covers areas such as automatic subscription renewals, limitations of liability, resolution of disputes by mandatory arbitration rather than a judge or jury in a court of law, and a class action waiver.</p>

<p><strong>Your Relationship with NDIM VECOSPACE</strong></p>

<ul>
	<li>By using our Platform, you are agreeing to our Terms of Service. That is a legally binding agreement between you and NDIM VECOSPACE.</li>
	<li>If you break the rules, we may suspend or terminate your account.</li>
	<li>We charge for certain aspects of our Platform, and some of these fees are billed on a regular and recurring basis (unless you disable auto-renewal or cancel your subscription).</li>
</ul>

<p><strong>NDIM VECOSPACE Groups, Organizers and Members</strong></p>

<ul>
	<li>Organizers may establish<a href="https://www.meetup.com/terms/#section2.1">membership criteria</a>for their own NDIM VECOSPACE groups. Whilethere is probably a NDIM VECOSPACE group out there for everyone, not every NDIM VECOSPACE group is for you. If you can&rsquo;t find the right group, you can easily <a href="https://meetup.zendesk.com/hc/articles/360002474472-Creating-your-Meetup-group">start your own NDIM VECOSPACE group</a>.</li>
	<li>Organizers may charge <a href="https://www.meetup.com/terms/#section3.2">fees for memberships or events</a>.</li>
	<li>Using our Platform involves meeting real people and doing real things in the real world, which can sometimes lead to unexpected situations. We can&rsquo;t control what happens in the real world, and<a href="https://www.meetup.com/terms/#section6">we are not responsible for it</a>. You should use common sense and good judgment when interacting with others.</li>
</ul>

<p><strong>Your Content and Content of Others</strong></p>

<ul>
	<li>You are responsible for your &ldquo;Content&rdquo;, which means any information, material, or other content posted to our Platform. Your Content must comply with our Terms of Service, which includes the<a href="https://meetup.zendesk.com/hc/sections/360000683791-Community-Guidelines">Usage and Content Policies</a>, <a href="https://meetup.zendesk.com/hc/sections/360000683791-Community-Guidelines">Group Policies</a>, <a href="https://meetup.zendesk.com/hc/sections/360000683791-Community-Guidelines">Member Restrictions</a>, <a href="https://www.meetup.com/paypolicies/">Payment Policies</a> etc. Your Content is also subject to our <a href="https://meetup.zendesk.com/hc/articles/360001674451-Intellectual-Property-Dispute-Policies">Intellectual Property Dispute Policies</a>.</li>
	<li>We do not own the Content that you post. However, we do require that<a href="https://www.meetup.com/terms/#section4.2">you provide us a license</a> to use this Content for us to operate, improve, promote, and protect NDIM VECOSPACE and our Platform for the benefit of you and others.</li>
	<li>We are not responsible for Content that members post or the communications that members send using our Platform.</li>
	<li>&nbsp;We generally don&rsquo;t review Content before it&rsquo;s posted. If you see Content that violates our Terms of Service, you may <a href="https://meetup.zendesk.com/hc/articles/360001673551-Report-spam-or-inappropriate-content">report inappropriate Content</a> to us.</li>
</ul>

<p><strong>Our Platform</strong></p>

<ul>
	<li>We try hard to make sure that our Platform is always available and working, but we cannot guarantee it will be. Occasionally things may not go exactly as planned. We apologize in advance for any inconvenience.</li>
	<li>We are continually improving our Platform. This means that we may modify or discontinue portions of our Platform.</li>
	<li>By using our Platform, you agree to the limitations of liability and release in our Terms of Service. Except as specified in our Terms of Service, you also agree to resolve any disputes you may have with us through arbitration, and you are waiving your right to seek relief from a judge or jury in a court of law, except as otherwise provided for in the Terms of Service. Claims can only be brought individually, and not as part of a class action.</li>
</ul>

<p><strong>Terms of Service</strong></p>

<p>1.&nbsp; <strong>The Agreement </strong></p>

<p>NDIM VECOSPACE enables you and other members to arrange off-line, real-world NDIM VECOSPACE groups and NDIM VECOSPACE events. The terms &ldquo;NDIM VECOSPACE,&rdquo; &ldquo;we,&rdquo; &ldquo;us,&rdquo; and &ldquo;our&rdquo; include NDIM VECOSPACE, Inc. and our affiliates. We use the terms &ldquo;you&rdquo; and &ldquo;your&rdquo; to mean any person using our Platform, and any organization or person using the Platform on an organization&rsquo;s behalf. We use the word &ldquo;Platform&rdquo; to mean any website, application, or service offered by NDIM VECOSPACE, including content we offer and electronic communications we send. We provide our Platform to you subject to these Terms of Service.</p>

<p>We use the terms &ldquo;Terms of Service&rdquo; and &ldquo;Agreement&rdquo; interchangeably to mean this document together with our <a href="https://meetup.zendesk.com/hc/sections/360000683791-Community-Guidelines">Usage and Content Policies</a>, <a href="https://meetup.zendesk.com/hc/sections/360000683791-Community-Guidelines">Group Policies</a> etc. Your use of the Platform signifies that you agree to this Agreement.</p>

<p>If you are using the Platform for an organization, you agree to this Agreement on behalf of that organization, and represent you have authority to bind that organization to the terms contained in this Agreement. If you do not or are unable to agree to this Agreement, do not use our Platform.</p>

<p>1.1<strong> Revisions to this Agreement</strong></p>

<p>We may modify this Agreement from time to time. When we do, we will provide notice to you by publishing the most current version and revising the date at the top of this page. If we make any material change to this Agreement, we will provide additional notice to you, such as by sending you an email or displaying a prominent notice on our Platform. By continuing to use the Platform after any changes come into effect, you agree to the revised Agreement.</p>

<p>&nbsp;</p>

<p>&nbsp;</p>

<p>&nbsp;</p>

<p>2. <strong>Your Account and Membership</strong></p>

<p>2.1 <strong>Eligibility</strong>-:&nbsp; Our Platform is available to anyone who is at least 18 years old. You represent that you are at least 18. Additional eligibility requirements for a portion of our Platform may be set by any member who can moderate or manage that portion of our Platform. For example, the eligibility requirements for a NDIM VECOSPACE group or NDIM VECOSPACE event may be set by the organizers of that group.</p>

<p>2.2 <strong>Suspension of Your Account</strong>-:We may modify, suspend or terminate your account or access to the Platform if, in our sole discretion, we determine that you have violated this Agreement, including any of the policies or guidelines that are part of this Agreement, that it is in the best interest of the NDIM VECOSPACE community, or to protect our brand or Platform. We also may remove accounts of members who are inactive for an extended period.</p>

<p>A member who can moderate or manage a portion of our Platform also has the ability, in his or her sole discretion, to modify, suspend, or terminate your access to that portion of the Platform.</p>

<p>2.3 <strong>Account Information and Security</strong> -: When you register, you provide us with some basic information, including an email address and a password. Keep your email address and other account information current and accurate. Also, you agree to maintain the security and confidentiality of your password (or else we may need to disable your account).</p>

<p>&nbsp;You alone are responsible for anything that happens from your failure to maintain that security and confidentiality, such as by sharing your account credentials with others. If someone is using your password, notify us immediately.</p>

<p>3. <strong>Fees, Payments and Offers</strong></p>

<p>3.1<strong>Fees Charged by NDIM VECOSPACE</strong> -: Use of some of the features on our Platform is free, and we charge fees for other features. We may in the future implement a new fee, or modify an existing fee, for certain current or future features of our Platform. If we implement a new or modified fee, we will give you advanced notice such as by posting changes on our Platform or sending you an email.</p>

<p>You agree to pay those fees and any associated taxes for your continued use of the applicable service. Unless otherwise stated, all fees and all transactions are in U.S. dollars. All fees are exclusive of applicable federal, state, local, or other taxes. Organizer subscriptions are non-transferable.</p>

<p>4. <strong>Your Content and Privacy</strong></p>

<p>4.1 <strong>Your Content</strong> -: You are solely responsible for your Content. We use the word &ldquo;Content&rdquo; to mean any information, material, or other content posted to our Platform or otherwise provide to us (such as feedback, comments, or suggestions shared with us). You agree that you and your Content shall not violate the rights of any third party (such as copyrights, trademarks, contract rights, privacy rights, or publicity rights),</p>

<p><a name="_GoBack"></a>&nbsp;this Agreement (including our<a href="https://meetup.zendesk.com/hc/sections/360000683791-Community-Guidelines">Usage and Content Policies</a>, <a href="https://meetup.zendesk.com/hc/sections/360000683791-Community-Guidelines">Group Policies</a>, , <a href="https://meetup.zendesk.com/hc/sections/360000683791-Community-Guidelines">Member Restrictions</a>, and <a href="https://meetup.zendesk.com/hc/articles/360001674451-Intellectual-Property-Dispute-Policies">Intellectual Property Policies</a>)</p>

<p>&nbsp;</p>

<p>4.2 <strong>Content License from You</strong> -:&nbsp; We do not claim ownership of your Content. However, to enable us to operate, improve, promote, and protect NDIM VECOSPACE and our Platform, and to ensure we do not violate any rights you may have in your Content, you hereby grant NDIM VECOSPACE a non-exclusive, worldwide, perpetual, irrevocable, royalty-free, sublicensable, transferable right and license (including a waiver of any moral rights) to use, host, store, reproduce, modify, publish, publicly display, publicly perform, distribute, and create derivative works of, your Content and to commercialize and exploit the copyright, trademark, publicity, and database rights you have in your Content.</p>

<p>&nbsp;</p>

<p>4.3 <strong>Privacy</strong>-: NDIM VECOSPACE collects registration and other information about you through our Platform. Please refer to our <a href="https://www.meetup.com/privacy/">Privacy Policy</a> and <a href="https://www.meetup.com/cookie_policy/">Cookie Policy</a> for details on how we collect, use, and disclose this information. These policies do not govern use of information that you provide to third parties, such as other members of NDIM VECOSPACE&rsquo;s Platform.</p>

<p>&nbsp;</p>

<p>5. <strong>Your Use of Our Platform</strong></p>

<p>5.1 <strong>Our Policies, Guidelines and Applicable Laws</strong> -: &nbsp;When you use our Platform, we require that you follow the <a href="https://meetup.zendesk.com/hc/sections/360000683791-Community-Guidelines">Usage and Content Policies</a>, <a href="https://meetup.zendesk.com/hc/sections/360000683791-Community-Guidelines">Member Restrictions</a>, <a href="https://www.meetup.com/terms/%7bPAY_URL%7d">Payment Policies</a> etc. You also agree to comply with all applicable laws, rules and regulations, and to not violate or infringe the rights of any third party. If you do not comply, we may modify, suspend or terminate your account or access to the Platform, in our sole discretion.</p>

<p>5.2 <strong>Content of Others</strong> -: NDIM VECOSPACE does not control the Content of other members. When we become aware of inappropriate Content on our Platform, we reserve the right to investigate and take appropriate action, but we do not have any obligation to monitor, nor do we take responsibility for, the Content of other members.</p>

<p>5.3 <strong>Interactions with Others </strong>-: NDIM VECOSPACE is not a party to any offline arrangements made through our Platform. NDIM VECOSPACE does not conduct or require background checks on members and does not attempt to verify the truth or accuracy of statements made by members. NDIM VECOSPACE makes no representations or warranties concerning the conduct or Content of any members or their interactions with you.</p>

<p>5.4 <strong>No Resale</strong> -:&nbsp; Our Platform contains proprietary and confidential information and is protected by intellectual property laws. Unless we expressly permit it through this Agreement, you agree not to modify, reproduce, sell or charge a fee, offer to sell or charge a fee, make, create derivative works based on, or distribute any part of our Platform, including any data, or Content of others.</p>

<p>5.5 <strong>No Technical Interference with the Platform </strong><strong>-: </strong>You agree that you will not engage in any activity or post any information or material that interferes with or disrupts, or that is designed to interfere with or disrupt, the Platform or any hardware used in connection with the Platform.</p>

<p>5.6 <strong>Platform Modifications</strong> -: We work hard to continuously improve our Platform. This means that we may modify or discontinue portions or all our Platform with or without notice and without liability to you or any third party.</p>

<p style="margin-left:36.0pt"><a name="section5.8"></a>6.<strong>Release </strong></p>

<p style="margin-left:36.0pt">You agree to release us and our officers, directors, shareholders, agents, employees, consultants, affiliates, subsidiaries, sponsors, and other third-party partners (referred to in this Agreement as &ldquo;NDIM VECOSPACE Parties&rdquo;) from claims, demands, and damages (direct and consequential) of every kind and nature, known and unknown, now and in the future (referred to in this Agreement as &ldquo;Claims&rdquo;), arising out of or in any way connected with any transaction with a third party, your interactions with other members, or in connection with a NDIM VECOSPACE group or a NDIM VECOSPACE event.</p>

<p style="margin-left:36.0pt">&nbsp;You also agree to release organizers from Claims based on an organizer&rsquo;s negligence arising out of or in any way connected with their Content, a NDIM VECOSPACE group, or a NDIM VECOSPACE event.</p>

<p style="margin-left:36.0pt">You further waive all rights and benefits otherwise conferred by any statutory or non-statutory law of any jurisdiction that would purport to limit the scope of a release or waiver. You waive and relinquish all rights and benefits that you have or may have under any similar provision of statutory or non-statutory law of any other jurisdiction fully permitted by law.</p>

<p style="margin-left:36.0pt">&nbsp;</p>

<p>7.<strong>Warranty Disclaimer and Limitation of Liability</strong></p>

<p>&nbsp;</p>

<p>7.1 <strong>Warranty Disclaimer</strong> -: Our Platform is provided to you &ldquo;as is&rdquo; and on an &ldquo;as available&rdquo; basis. We disclaim all warranties and conditions of any kind, including but not limited to statutory warranties, and the implied warranties of merchantability, fitness for a purpose, and non-infringement. We also disclaim any warranties regarding (a) the reliability, timeliness, accuracy, and performance of our Platform, (b) any information, advice, services, or goods obtained through or advertised on our Platform or by us, as well as for any information or advice received through any links to other websites or resources provided through our Platform, (c) the results that may be obtained from the Platform, and (d) the correction of any errors in the Platform, (e) any material or data obtained through the use of our Platform, and (f) dealings with or as the result of the presence of marketing partners or other third parties on or located through our Platform.</p>

<p>7.2 <strong>Limitation of Liability</strong> -: You agree that in no event shall any NDIM VECOSPACE Parties be liable for any direct, indirect, incidental, special, or consequential damages, including but not limited to, damages for loss of profits, goodwill, use, data, or other intangible losses (even if any NDIM VECOSPACE Parties have been advised of the possibility of such damages) arising out of or in connection with (a) our Platform or this Agreement or the inability to use our Platform (however arising, including our negligence), (b) statements or conduct of or transactions with any member or third party on the Platform, (c) your use of our Platform or transportation to or from NDIM VECOSPACE events, attendance at NDIM VECOSPACE events, participation in or exclusion from NDIM VECOSPACE groups or NDIM VECOSPACE events and the actions of you or others at NDIM VECOSPACE events, or (d) any other matter relating to the Platform.</p>

<p>8. <strong>Dispute Resolution</strong></p>

<p>8.1<strong>Informal Resolution</strong> -: Before making any claim, you and NDIM VECOSPACE agree to try to resolve any disputes through good faith discussions. We use the term &ldquo;claim&rdquo; to mean any dispute, claim or controversy arising out of or relating to your use of our Platform or this Agreement, including your participation in NDIM VECOSPACE events. You or NDIM VECOSPACE may initiate this process by sending written notice describing the dispute and your proposed resolution. If we cannot resolve the issue within 30 business days of receipt of the initial notice, you or NDIM VECOSPACE may bring a claim in accordance</p>

<p>8.2 <strong>Arbitration Agreement </strong>-:&nbsp; you agree to submit any claim for final and binding arbitration. In arbitration certain rights that you or we would have in court may not be available, such as discovery or appeal. You and NDIM VECOSPACE are each expressly waiving any right to trial by judge or jury in a court of law. This agreement to arbitrate shall apply regardless of whether the claim arises during or after any termination of this Agreement or your relationship with NDIM VECOSPACE.</p>

<p>8.3<strong>Arbitration Time for Filing</strong>-:Any claim subject to arbitration must be filed within one year after the date the party asserting the claim first knows or should know of the act, omission or default giving rise to the claim, or the shortest time permitted by applicable law.</p>

<p>8.4<strong>Arbitration Procedures</strong>-:Either party may commence arbitration by filing a written demand for arbitration with NDIM VECOSPACE, with a copy to the other party according to the notice procedures in Section 10.1 The arbitration will be conducted in accordance with <a href="https://www.jamsadr.com/rules-streamlined-arbitration/" target="_blank">NDIM VECOSPACE Streamlined Arbitration Rules and Procedures</a> and any other applicable rules that NDIM VECOSPACE requires (&ldquo;NDIM VECOSPACE Rules&rdquo;) in effect as of the demand for arbitration. You agree that arbitration law govern the interpretation and enforcement of these arbitration provisions. Any arbitration hearings can take place anywhere in the world.</p>

<p>&nbsp;It isyour responsibility to pay any filing, administrative and arbitrator fees will be solely as set forth in the NDIM VECOSPACE Rules. The parties will cooperate with NDIM VECOSPACE and each other in scheduling the arbitration proceedings, and in selecting one arbitrator from the appropriate NDIM VECOSPACE list with substantial experience in resolving intellectual property and contract disputes. The arbitrator shall follow this Agreement and, to the extent permitted by NDIM VECOSPACE Rules, can award costs, fees and expenses, including attorneys&rsquo; fees to the prevailing party, except that the arbitrator shall not award declaratory or injunctive relief benefiting anyone but the parties to the arbitration. Judgment upon the award rendered by such arbitrator may be entered in any court of competent jurisdiction.</p>

<p>8.5<strong>Exceptions</strong> -: You or NDIM VECOSPACE may assert claims, if they qualify, in small claims court, You or NDIM VECOSPACE may seek injunctive relief from a court of competent jurisdiction as necessary to protect the intellectual property rights of you or NDIM VECOSPACE pending the completion of arbitration.</p>

<p>NDIM VECOSPACE may act in court or arbitration to collect any fees or recover damages for, or to seek injunctive relief relating to, Platform operations, or unauthorized use of our Platform or intellectual property. Nothing in this Section 9 shall diminish NDIM VECOSPACE&rsquo;s right to modify, suspend or terminate your account or access to our Platform under Section 2.2.</p>

<p>8.6<strong>Class Action Waiver</strong> -: You agree to resolve disputes with NDIM VECOSPACE on an individual basis. You agree not to bring a claim as a plaintiff or a class member in a class, consolidated or representative action. You are expressly waiving any right to participate in class actions, class arbitrations, private attorney general actions and consolidation with other arbitrations.</p>

<p>9. <strong>Intellectual Property </strong></p>

<p>9.1<strong>Intellectual Propertyof NDIM VECOSPACE</strong> -: NDIM VECOSPACE trademarks, logos, service marks, and service names are the intellectual property of NDIM VECOSPACE. Our <a href="https://meetup.zendesk.com/hc/articles/360001655932-Meetup-Trademark-Guidelines">Trademark Usage Guidelines</a> explain how you may and may not use them. Our Platform, including our material on the Platform, are also our or our licensors&rsquo; intellectual property, and as otherwise permitted by law, you agree not to use our intellectual property without our prior written consent.</p>

<p>9.2 <strong>Intellectual Property of Others</strong> -: NDIM VECOSPACE respects the intellectual property of others, and we expect our members to do the same. We may, in appropriate circumstances and in our discretion, remove or disable access to material that infringes on the intellectual property rights of others. We may also restrict or terminate access to our Platform to those who we believe to be repeat infringers. If you believe your intellectual property rights have been violated, please review our <a href="https://meetup.zendesk.com/hc/articles/360001674451-Intellectual-Property-Dispute-Policies">Intellectual Property Dispute Policies</a>.</p>

<p>10. <strong>Other Stuff</strong></p>

<p>10.1 <strong>Notices</strong> -: Except as otherwise stated in this Agreement or as expressly required by law, any notice to us shall be given by certified postal mail to a given address, or by email to legal@NDIM VECOSPACE.com. Any notice to you shall be given to the most current email address in your account.</p>

<p>10.2 <strong>Termination</strong>-: If we terminate your account or access to our Platform, this Agreement terminates with respect to the member account that has been terminated. However, certain provisions of this Agreement that by their nature survive termination</p>

<p>10.3<strong>Violations</strong> -: Please report any violations of this Agreement by a member or third party by sending an email to <a href="mailto:abuse@NDIM VECOSPACE.com">abuse@NDIM VECOSPACE.com</a></p>

<p>10.4 <strong>Thank you</strong> -: Please accept our wholehearted thanks for reading our Terms of Service.</p>
      </div>
    </div>
  </div>
  </div>
  <?php include('backtotop.php'); ?>
</body>

</html>