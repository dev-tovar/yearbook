<?php
/**
 * Created by PhpStorm.
 * User: tabbakka
 * Date: 7/12/18
 * Time: 8:16 PM
 */

namespace App\Http\Controllers\Api;


use App\Helpers\ApiResponseGenerator;
use App\Http\Controllers\Controller;
use App\School;

class DataController extends Controller {
	private $reasons = [
		[
			'id' => 0,
			'value' => 'I broke something'
		],
		[
			'id' => 1,
			'value' => 'It is not working good'
		],
		[
			'id' => 2,
			'value' => 'Something else?'
		]
	];

	public function get() {
		return ApiResponseGenerator::responseTrue([
			"schools" => School::all(),
			"cities" => null,
			"states" => null,
			"reasons" => $this->reasons,
			"terms" => '<h3>TERMS OF SERVICE</h3>
<h4>Overview</h4>
<p>This website, software, and mobile application is operated by Pocket Yearbook, LLC.. The
    terms “we”, “us” and “our” refer to Pocket Yearbook, LLC.. Pocket Yearbook, LLC. offers this
    service, including all information, tools and services available from this site, software, and
    app to you, the user, conditioned upon your acceptance of all terms, conditions, policies and
    notices stated here.</p>
<p>By visiting our service and/ or purchasing something from us, you engage in our “Service”
    and agree to be bound by the following terms and conditions (“Terms of Service”, “Terms”),
    including those additional terms and conditions and policies referenced herein and/or
    available by hyperlink. These Terms of Service apply to all users of the site, including,
    without limitation, users who are browsers, vendors, customers, merchants, and/ or
    contributors of content.</p>
<p>Please read these Terms of Service carefully before accessing or using our website. By
    accessing or using any part of the site, you agree to be bound by these Terms of Service. If
    you do not agree to all the terms and conditions of this agreement, then you may not access
    or use any services. If these Terms of Service are considered an offer, acceptance is
    expressly limited to these Terms of Service.</p>
<p>Any new features or tools which are added to the current site shall also be subject to the
    Terms of Service. You can review the most current version of the Terms of Service at any
    time on this page. We reserve the right to update, change or replace any part of these
    Terms of Service by posting updates and/or changes to our website and app. It is your
    responsibility to check this page periodically for changes. Your continued use of or access
    to the website following the posting of any changes constitutes acceptance of those
    changes.</p>
<h4>Access by Users</h4>
<p>By agreeing to these Terms of Service, you represent that you are at least the age of
    majority in your state or province of residence, or that you are the age of majority in your
    state or province of residence and you have given us your consent to allow any of your
    minor dependents to use this site. If you are not of legal age, your parent or guardian must
    sign our waiver.</p>
<p>You may not use our products for any illegal or unauthorized purpose nor may you, in the
    use of the Service, violate any laws in your jurisdiction (including but not limited to
    copyright laws).</p>
<p>The content on our service shall only be used for the intended purpose of accessing a news
    feed, notifications, social media connections, writing on walls, purchasing student tribute
    pages, and a digital yearbook, which will be only available for purchase by a school, its
    students or parents (“User”). Any other use is strictly prohibited. Cyber-Bullying will not be
    tolerated. In the event your school notify us that you have engaged in such activity you
    shall cease to have access to the content of our site or app.</p>
<p>Users will be required to enter their individual access code, provided by the School, in
    order to be able to purchase the Product. Users may not share their code with others.</p>
<p>You must not transmit any worms or viruses or any code of a destructive nature.</p>
<p>A breach or violation of any of the Terms will result in an immediate termination of your
    Services with no refund.</p>
<h4>Protection of Children’s Information</h4>
<p>No one under age 13 may provide any information to the Pocket Yearbook, LLC. website.
    Protecting the privacy of children is extremely important to Pocket Yearbook, LLC.. The
    Pocket Yearbook, LLC. Website is not intended for use by children under 13 years of age
    without the supervision of a parent. Pocket Yearbook, LLC. does not knowingly collect
    personal data from children under the age of 13. If a potential user is under the age of 13,
    the potential user should not use or submit any personal data (including information about
    the potential user, including but not limited to: name, address, telephone number, e-mail
    address or any screen name or username) on or through the Pocket Yearbook, LLC.
    Website. If Pocket Yearbook, LLC. learns personal information from a child under 13 has
    been collected or received without verification of parental consent, Pocket Yearbook, LLC.
    will delete that information.</p>
<p>Pocket Yearbook, LLC. encourages parents and legal guardians to monitor their children’s
    internet usage and to help enforce this Policy by instructing their children never to provide
    personal data through the Pocket Yearbook, LLC. Website without parental consent. If the
    user has reason to believe that a child under the age of 13 has provided personal data to
    Pocket Yearbook, LLC. through the Pocket Yearbook, LLC. Website without parental
    consent, please contact Pocket Yearbook, LLC. at Nicholaswilliams80@gmail.com or
    305-896-6167.</p>
<h4>General Conditions</h4>
<p>We reserve the right to refuse service to anyone for any reason at any time.</p>
<p>You understand that your content (not including credit card information), may be
    transferred unencrypted and involve (a) transmissions over various networks; and (b)
    changes to conform and adapt to technical requirements of connecting networks or
    devices. Credit card information is always encrypted during transfer over networks.</p>
<p>You agree not to reproduce, duplicate, copy, sell, resell or exploit any portion of the Service,
    use of the Service, or access to the Service or any contact on the site through which the
    service is provided, without express written permission by us.</p>
<p>The headings used in this agreement are included for convenience only and will not limit or
    otherwise affect these Terms.</p>
<h4>Accuracy, Completeness and Timeliness of Information</h4>
<p>We are not responsible if information made available on this site is not accurate, complete
    or current. The material on this site is provided for general information only and should
    not be relied upon or used as the sole basis for making decisions without consulting
    primary, more accurate, more complete or more timely sources of information. Any
    reliance on the material on this site is at your own risk.</p>
<p>This site may contain certain historical information. Historical information, necessarily, is
    not current and is provided for your reference only. We reserve the right to modify the
    contents of this site at any time, but we have no obligation to update any information on
    our site. You agree that it is your responsibility to monitor changes to our site.</p>
<h4>Modifications to The Service and Prices</h4>
<p>Prices for our products are subject to change without notice.</p>
<p>A Service Fee of up to $1.99 will apply after the two (2) year grace period. This fee will be a
    yearly subscription fee to access each yearbook in your Collection after your grace period
    has expired.</p>
<p>User’s school shall maintain ownership of all photographs and other materials submitted
    by School through the Software (the “School Content”) and published by us. Therefore, the
    school shall have the right to request removal of any and all School Content, at any time, for
    any reason.</p>
<p>No refunds will be given if the school administration terminates the Services. Content will
    remain live if a request for removal is not made and users will be able to access such
    content. Should the school administration request for the content to be removed, users will
    not have access to such content and no refund will be given.</p>
<p>We reserve the right at any time to modify or discontinue the Service (or any part or
    content thereof) without notice at any time.</p>
<p>We shall not be liable to you or to any third-party for any modification, price change,
    suspension or discontinuance of the Service.</p>
<h4>Accuracy of Billing and Account Information</h4>
<p>We reserve the right to refuse any order you place with us. We may, in our sole discretion,
    limit or cancel quantities purchased per person, per household or per order. These
    restrictions may include orders placed by or under the same customer account, the same
    credit card, and/or orders that use the same billing and/or shipping address. In the event
    that we make a change to or cancel an order, we may attempt to notify you by contacting
    the e-mail and/or billing address/phone number provided at the time the order was made.
    We reserve the right to limit or prohibit orders that, in our sole judgment, appear to be
    placed by dealers, resellers or distributors.</p>
<p>You agree to provide current, complete and accurate purchase and account information for
    all purchases made on our website or mobile app. You agree to promptly update your
    account and other information, including your email address and credit card numbers and
    expiration dates, so that we can complete your transactions and contact you as needed.</p>
<h4>Optional Tools</h4>
<p>We may provide you with access to third-party tools over which we neither monitor nor
    have any control nor input.</p>
<p>You acknowledge and agree that we provide access to such tools “as-is” and “as available”
    without any warranties, representations or conditions of any kind and without any
    endorsement. We shall have no liability whatsoever arising from or relating to your use of
    optional third-party tools.</p>
<p>Any use by you of optional tools offered through the site is entirely at your own risk and
    discretion and you should ensure that you are familiar with and approve of the terms on
    which tools are provided by the relevant third-party provider(s).</p>
<p>We may also, in the future, offer new services and/or features through the website
    (including, the release of new tools and resources). Such new features and/or services shall
    also be subject to these Terms of Service.</p>
<h4>Third-Party Links</h4>
<p>Certain content, products and services available via our Service may include materials from
    third-parties.</p>
<p>Third-party links on this site may direct you to third-party websites that are not affiliated
    with us. We are not responsible for examining or evaluating the content or accuracy and we
    do not warrant and will not have any liability or responsibility for any third-party materials
    or websites, or for any other materials, products, or services of third-parties.</p>
<p>We are not liable for any harm or damages related to the purchase or use of goods, services,
    resources, content, or any other transactions made in connection with any third-party
    websites. Please review carefully the third-party\'s policies and practices and make sure you
    understand them before you engage in any transaction. Complaints, claims, concerns, or
    questions regarding third-party products should be directed to the third-party.</p>
<h4>User Comments, Feedback and Other Submissions</h4>
<p>If, at our request, you send certain specific submissions (for example contest entries) or
    without a request from us you send creative ideas, suggestions, proposals, plans, or other
    materials, whether online, by email, by postal mail, or otherwise (collectively, \'comments\'),
    you agree that we may, at any time, without restriction, edit, copy, publish, distribute,
    translate and otherwise use, in any medium, any comments that you forward to us. We are
    and shall be under no obligation to (1) maintain any comments in confidence; (2) pay
    compensation for any comments; or (3) respond to any comments.</p>
<p>We may, but have no obligation to, monitor, edit or remove content that we determine in
    our sole discretion is unlawful, offensive, threatening, libelous, defamatory, pornographic,
    obscene or otherwise objectionable or violates any party’s intellectual property or these
    Terms of Service.</p>
<p>You agree that your comments will not violate any right of any third-party, including
    copyright, trademark, privacy, personality or other personal or proprietary right. You
    further agree that your comments will not contain libelous or otherwise unlawful, abusive
    or obscene material, or contain any computer virus or other malware that could in any way
    affect the operation of the Service or any related website. You may not use a false e-mail
    address, pretend to be someone other than yourself or otherwise mislead us, or
    third-parties as to the origin of any comments. You are solely responsible for any
    comments you make and their accuracy. We take no responsibility and assume no liability
    for any comments posted by you or any third-party.</p>
<h4>Personal Information</h4>
<p>Your submission of personal information through our website or mobile app is governed
    by our Privacy Policy. For more details, see our Privacy Policy.</p>
<h4>Errors, Inaccuracies and Omissions</h4>
<p>Occasionally there may be information on our site or in the Service that contains
    typographical errors, inaccuracies or omissions that may relate to product descriptions,
    pricing, promotions, offers, product shipping charges, transit times and availability. We
    reserve the right to correct any errors, inaccuracies or omissions, and to change or update
    information or cancel orders if any information in the Service or on any related website is
    inaccurate at any time without prior notice (including after you have submitted your
    order).</p>
<p>We undertake no obligation to update, amend or clarify information in the Service or on
    any related website, including without limitation, pricing information, except as required
    by law. No specified update or refresh date applied in the Service or on any related website,
    should be taken to indicate that all information in the Service or on any related website has
    been modified or updated.</p>
<h4>Prohibited Uses</h4>
<p>In addition to other prohibitions as set forth in the Terms of Service, you are prohibited
    from using the site or its content: (a) for any unlawful purpose; (b) to solicit others to
    perform or participate in any unlawful acts; (c) to violate any international, federal,
    provincial or state regulations, rules, laws, or local ordinances; (d) to infringe upon or
    violate our intellectual property rights or the intellectual property rights of others; (e) to
    harass, abuse, insult, harm, defame, slander, disparage, intimidate, or discriminate based on
    gender, sexual orientation, religion, ethnicity, race, age, national origin, or disability; (f) to
    submit false or misleading information; (g) to upload or transmit viruses or any other type
    of malicious code that will or may be used in any way that will affect the functionality or
    operation of the Service or of any related website, other websites, or the Internet; (h) to
    collect or track the personal information of others; (i) to spam, phish, pharm, pretext,
    spider, crawl, or scrape; (j) for any obscene or immoral purpose; or (k) to interfere with or
    circumvent the security features of the Service or any related website, other websites, or
    the Internet. We reserve the right to terminate your use of the Service or any related
    website for violating any of the prohibited uses.</p>
<h4>Disclaimer of Warranties; Limitation of Liability</h4>
<p>We do not guarantee, represent or warrant that your use of our service will be
    uninterrupted, timely, secure or error-free.</p>
<p>We do not warrant that the results that may be obtained from the use of the service will be
    accurate or reliable.</p>
<p>You agree that from time to time we may remove the service for indefinite periods of time
    or cancel the service at any time, without notice to you.</p>
<p>You expressly agree that your use of, or inability to use, the service is at your sole risk. The
    service and all products and services delivered to you through the service are (except as
    expressly stated by us) provided \'as is\' and \'as available\' for your use, without any
    representation, warranties or conditions of any kind, either express or implied, including
    all implied warranties or conditions of merchantability, merchantable quality, fitness for a
    particular purpose, durability, title, and non-infringement.</p>
<p>In no case shall Pocket Yearbook, LLC., our directors, officers, employees, affiliates, agents,
    contractors, interns, suppliers, service providers or licensors be liable for any injury, loss,
    claim, or any direct, indirect, incidental, punitive, special, or consequential damages of any
    kind, including, without limitation lost profits, lost revenue, lost savings, loss of data,
    replacement costs, or any similar damages, whether based in contract, tort (including
    negligence), strict liability or otherwise, arising from your use of any of the service or any
    products procured using the service, or for any other claim related in any way to your use
    of the service or any product, including, but not limited to, any errors or omissions in any
    content, or any loss or damage of any kind incurred as a result of the use of the service or
    any content (or product) posted, transmitted, or otherwise made available via the service,
    even if advised of their possibility. Because some states or jurisdictions do not allow the
    exclusion or the limitation of liability for consequential or incidental damages, in such
    states or jurisdictions, our liability shall be limited to the maximum extent permitted by
    law.</p>
<h4>Indemnification</h4>
<p>You agree to indemnify, defend and hold harmless Pocket Yearbook, LLC. and our parent,
    subsidiaries, affiliates, partners, officers, directors, agents, contractors, licensors, service
    providers, subcontractors, suppliers, interns and employees, harmless from any claim or
    demand, including reasonable attorneys’ fees, made by any third-party due to or arising out
    of your breach of these Terms of Service or the documents they incorporate by reference,
    or your violation of any law or the rights of a third-party.</p>
<h4>Severability</h4>
<p>In the event that any provision of these Terms of Service is determined to be unlawful, void
    or unenforceable, such provision shall nonetheless be enforceable to the fullest extent
    permitted by applicable law, and the unenforceable portion shall be deemed to be severed
    from these Terms of Service, such determination shall not affect the validity and
    enforceability of any other remaining provisions.</p>
<h4>Entire Agreement</h4>
<p>The failure of us to exercise or enforce any right or provision of these Terms of Service
    shall not constitute a waiver of such right or provision.</p>
<p>These Terms of Service and any policies or operating rules posted by us on this site or in
    respect to The Service constitutes the entire agreement and understanding between you
    and us and govern your use of the Service, superseding any prior or contemporaneous
    agreements, communications and proposals, whether oral or written, between you and us
    (including, but not limited to, any prior versions of the Terms of Service).</p>
<p>Any ambiguities in the interpretation of these Terms of Service shall not be construed
    against the drafting party.</p>
<h4>Governing Law</h4>
<p>These Terms of Service and any separate agreements whereby we provide you Services
    shall be governed by and construed in accordance with the laws of the State of Florida.</p>
<h4>Changes to Terms of Service</h4>
<p>You can review the most current version of the Terms of Service at any time at this page.</p>
<p>We reserve the right, at our sole discretion, to update, change or replace any part of these
    Terms of Service by posting updates and changes to our website. It is your responsibility to
    check our website periodically for changes. Your continued use of or access to our website
    or the Service following the posting of any changes to these Terms of Service constitutes
    acceptance of those changes.</p>
<h4>Contact Information</h4>
<p>Questions about the Terms of Service should be sent to us at
    stayconnected@pocketyearbook.com</p>'
		]);
	}

	public function getUserPolicy() {
		return ApiResponseGenerator::responseTrue([
			'policy' => '<h3>PRIVACY POLICY</h3>
<p>Effective date: August 20, 2018</p>
<p>Pocket Yearbook, LLC. ("us", "we", or "our") operates the www.pocketyearbook.com
    website, software, and mobile application (hereinafter referred to as the "Service"). This
    page informs you of our policies regarding the collection, use, and disclosure of personal
    data when you use our Service and the choices you have associated with that data. We use
    your data to provide and improve the Service. By using the Service, you agree to the
    collection and use of information in accordance with this policy. Unless otherwise defined
    in this Privacy Policy, the terms used in this Privacy Policy have the same meanings as in
    our Terms and Conditions, accessible from www.pocketyearbook.com</p>
<h4>Information Collection and Use</h4>
<p>We collect several different types of information for various purposes to provide and
    improve our Service to you.</p>
<h4>Types of Data Collected</h4>
<p>Personal Data:</p>
<p>While using our Service, we may ask you to provide us with certain personally identifiable
    information that can be used to contact or identify you ("Personal Data"). Personally
    identifiable information may include, but is not limited to:</p>
<ol>
    <li>Email address</li>
    <li>First name and last name</li>
    <li>Phone number</li>
    <li>Address, State, Province, ZIP/Postal code, City</li>
    <li>Grade level</li>
    <li>School attending</li>
    <li>Identification number</li>
    <li>Verification code</li>
    <li>Photos/videos</li>
    <li>Payment Information</li>
    <li>Cookies and Usage Data</li>
</ol>
<h4>Usage Data</h4>
<p>We may also collect information on how the Service is accessed and used ("Usage Data").
    This Usage Data may include information such as your computer\'s Internet Protocol
    address (e.g. IP address), browser type, browser version, the pages of our Service that you
    visit, the time and date of your visit, the time spent on those pages, unique device
    identifiers and other diagnostic data.</p>
<h4>Data</h4>
<p>Use of Data:</p>
<p>Pocket Yearbook, LLC. uses the collected data for various purposes:</p>
<ol>
    <li>To provide and maintain the Service</li>
    <li>To allow you to participate in interactive features of our Service when you choose to do so</li>
    <li>To provide customer care and support</li>
    <li>To provide analysis or valuable information so that we can improve the Service</li>
    <li>To monitor the usage of the Service</li>
    <li>To detect, prevent and address technical issues</li>
    <li>To allow students, parents, and alumni to stay connected!</li>
    <li>To allow schools to connect with their students, parents, and alumni</li>
</ol>
<h4>Transfer of Data</h4>
<p>Your information, including Personal Data, may be transferred to — and maintained on —
    computers located outside of your state, province, country or other governmental
    jurisdiction where the data protection laws may differ than those from your jurisdiction.</p>
<p>If you are located outside United States and choose to provide information to us, please
    note that we transfer the data, including Personal Data, to United States and process it
    there. Your consent to this Privacy Policy followed by your submission of such information
    represents your agreement to that transfer.</p>
<p>Pocket Yearbook, LLC will take all steps reasonably necessary to ensure that your data is
    treated securely and in accordance with this Privacy Policy and no transfer of your
    Personal Data will take place to an organization or a country unless there are adequate
    controls in place including the security of your data and other personal information.</p>
<h4>Disclosure of Data</h4>
<p>Legal Requirements:</p>
<p>Pocket Yearbook, LLC. may disclose your Personal Data in the good faith belief that such
    action is necessary to:</p>
<ol>
    <li>To comply with a legal obligation</li>
    <li>To protect and defend the rights or property of Pocket Yearbook, LLC.</li>
    <li>To prevent or investigate possible wrongdoing in connection with the Service</li>
    <li>To protect the personal safety of users of the Service or the public</li>
    <li>To protect against legal liability</li>
</ol>
<h4>Security of Data</h4>
<p>The security of your data is important to us, but remember that no method of transmission
    over the Internet, or method of electronic storage is 100% secure. While we strive to use
    commercially acceptable means to protect your Personal Data, we cannot guarantee its
    absolute security.</p>
<h4>Service Providers</h4>
<p>We may employ third party companies and individuals to facilitate our Service ("Service
    Providers"), to provide the Service on our behalf, to perform Service-related services or to
    assist us in analyzing how our Service is used.</p>
<p>These third parties have access to your Personal Data only to perform these tasks on our
    behalf and are obligated not to disclose or use it for any other purpose.</p>
<h4>Links to Other Sites</h4>
<p>Our Service may contain links to other sites that are not operated by us. If you click on a
    third-party link, you will be directed to that third party\'s site. We strongly advise you to
    review the Privacy Policy of every site you visit.</p>
<p>We have no control over and assume no responsibility for the content, privacy policies or
    practices of any third-party sites or services.</p>
<h4>Changes to This Privacy Policy</h4>
<p>We may update our Privacy Policy from time to time. We will notify you of any changes by
    posting the new Privacy Policy on this page.</p>
<p>You are advised to review this Privacy Policy periodically for any changes. Changes to this
    Privacy Policy are effective when they are posted on this page.</p>
<h4>Contact Us</h4>
<p>If you have any questions about this Privacy Policy, please contact us via email:
    stayconnected@pocketyearbook.com</p>'
		]);
	}

	public function getSchools() {
		return ApiResponseGenerator::responseTrue(School::all());
	}

	public function getCities() {

	}

	public function getStates() {

	}

	public function getReasons() {
		return ApiResponseGenerator::responseTrue([
			"reasons" => $this->reasons
		]);
	}

	public function getUserTerms() {
		return ApiResponseGenerator::responseTrue([
			'terms' => '<h3>TERMS OF SERVICE</h3>
<h4>Overview</h4>
<p>This website, software, and mobile application is operated by Pocket Yearbook, LLC.. The
    terms “we”, “us” and “our” refer to Pocket Yearbook, LLC.. Pocket Yearbook, LLC. offers this
    service, including all information, tools and services available from this site, software, and
    app to you, the user, conditioned upon your acceptance of all terms, conditions, policies and
    notices stated here.</p>
<p>By visiting our service and/ or purchasing something from us, you engage in our “Service”
    and agree to be bound by the following terms and conditions (“Terms of Service”, “Terms”),
    including those additional terms and conditions and policies referenced herein and/or
    available by hyperlink. These Terms of Service apply to all users of the site, including,
    without limitation, users who are browsers, vendors, customers, merchants, and/ or
    contributors of content.</p>
<p>Please read these Terms of Service carefully before accessing or using our website. By
    accessing or using any part of the site, you agree to be bound by these Terms of Service. If
    you do not agree to all the terms and conditions of this agreement, then you may not access
    or use any services. If these Terms of Service are considered an offer, acceptance is
    expressly limited to these Terms of Service.</p>
<p>Any new features or tools which are added to the current site shall also be subject to the
    Terms of Service. You can review the most current version of the Terms of Service at any
    time on this page. We reserve the right to update, change or replace any part of these
    Terms of Service by posting updates and/or changes to our website and app. It is your
    responsibility to check this page periodically for changes. Your continued use of or access
    to the website following the posting of any changes constitutes acceptance of those
    changes.</p>
<h4>Access by Users</h4>
<p>By agreeing to these Terms of Service, you represent that you are at least the age of
    majority in your state or province of residence, or that you are the age of majority in your
    state or province of residence and you have given us your consent to allow any of your
    minor dependents to use this site. If you are not of legal age, your parent or guardian must
    sign our waiver.</p>
<p>You may not use our products for any illegal or unauthorized purpose nor may you, in the
    use of the Service, violate any laws in your jurisdiction (including but not limited to
    copyright laws).</p>
<p>The content on our service shall only be used for the intended purpose of accessing a news
    feed, notifications, social media connections, writing on walls, purchasing student tribute
    pages, and a digital yearbook, which will be only available for purchase by a school, its
    students or parents (“User”). Any other use is strictly prohibited. Cyber-Bullying will not be
    tolerated. In the event your school notify us that you have engaged in such activity you
    shall cease to have access to the content of our site or app.</p>
<p>Users will be required to enter their individual access code, provided by the School, in
    order to be able to purchase the Product. Users may not share their code with others.</p>
<p>You must not transmit any worms or viruses or any code of a destructive nature.</p>
<p>A breach or violation of any of the Terms will result in an immediate termination of your
    Services with no refund.</p>
<h4>Protection of Children’s Information</h4>
<p>No one under age 13 may provide any information to the Pocket Yearbook, LLC. website.
    Protecting the privacy of children is extremely important to Pocket Yearbook, LLC.. The
    Pocket Yearbook, LLC. Website is not intended for use by children under 13 years of age
    without the supervision of a parent. Pocket Yearbook, LLC. does not knowingly collect
    personal data from children under the age of 13. If a potential user is under the age of 13,
    the potential user should not use or submit any personal data (including information about
    the potential user, including but not limited to: name, address, telephone number, e-mail
    address or any screen name or username) on or through the Pocket Yearbook, LLC.
    Website. If Pocket Yearbook, LLC. learns personal information from a child under 13 has
    been collected or received without verification of parental consent, Pocket Yearbook, LLC.
    will delete that information.</p>
<p>Pocket Yearbook, LLC. encourages parents and legal guardians to monitor their children’s
    internet usage and to help enforce this Policy by instructing their children never to provide
    personal data through the Pocket Yearbook, LLC. Website without parental consent. If the
    user has reason to believe that a child under the age of 13 has provided personal data to
    Pocket Yearbook, LLC. through the Pocket Yearbook, LLC. Website without parental
    consent, please contact Pocket Yearbook, LLC. at Nicholaswilliams80@gmail.com or
    305-896-6167.</p>
<h4>General Conditions</h4>
<p>We reserve the right to refuse service to anyone for any reason at any time.</p>
<p>You understand that your content (not including credit card information), may be
    transferred unencrypted and involve (a) transmissions over various networks; and (b)
    changes to conform and adapt to technical requirements of connecting networks or
    devices. Credit card information is always encrypted during transfer over networks.</p>
<p>You agree not to reproduce, duplicate, copy, sell, resell or exploit any portion of the Service,
    use of the Service, or access to the Service or any contact on the site through which the
    service is provided, without express written permission by us.</p>
<p>The headings used in this agreement are included for convenience only and will not limit or
    otherwise affect these Terms.</p>
<h4>Accuracy, Completeness and Timeliness of Information</h4>
<p>We are not responsible if information made available on this site is not accurate, complete
    or current. The material on this site is provided for general information only and should
    not be relied upon or used as the sole basis for making decisions without consulting
    primary, more accurate, more complete or more timely sources of information. Any
    reliance on the material on this site is at your own risk.</p>
<p>This site may contain certain historical information. Historical information, necessarily, is
    not current and is provided for your reference only. We reserve the right to modify the
    contents of this site at any time, but we have no obligation to update any information on
    our site. You agree that it is your responsibility to monitor changes to our site.</p>
<h4>Modifications to The Service and Prices</h4>
<p>Prices for our products are subject to change without notice.</p>
<p>A Service Fee of up to $1.99 will apply after the two (2) year grace period. This fee will be a
    yearly subscription fee to access each yearbook in your Collection after your grace period
    has expired.</p>
<p>User’s school shall maintain ownership of all photographs and other materials submitted
    by School through the Software (the “School Content”) and published by us. Therefore, the
    school shall have the right to request removal of any and all School Content, at any time, for
    any reason.</p>
<p>No refunds will be given if the school administration terminates the Services. Content will
    remain live if a request for removal is not made and users will be able to access such
    content. Should the school administration request for the content to be removed, users will
    not have access to such content and no refund will be given.</p>
<p>We reserve the right at any time to modify or discontinue the Service (or any part or
    content thereof) without notice at any time.</p>
<p>We shall not be liable to you or to any third-party for any modification, price change,
    suspension or discontinuance of the Service.</p>
<h4>Accuracy of Billing and Account Information</h4>
<p>We reserve the right to refuse any order you place with us. We may, in our sole discretion,
    limit or cancel quantities purchased per person, per household or per order. These
    restrictions may include orders placed by or under the same customer account, the same
    credit card, and/or orders that use the same billing and/or shipping address. In the event
    that we make a change to or cancel an order, we may attempt to notify you by contacting
    the e-mail and/or billing address/phone number provided at the time the order was made.
    We reserve the right to limit or prohibit orders that, in our sole judgment, appear to be
    placed by dealers, resellers or distributors.</p>
<p>You agree to provide current, complete and accurate purchase and account information for
    all purchases made on our website or mobile app. You agree to promptly update your
    account and other information, including your email address and credit card numbers and
    expiration dates, so that we can complete your transactions and contact you as needed.</p>
<h4>Optional Tools</h4>
<p>We may provide you with access to third-party tools over which we neither monitor nor
    have any control nor input.</p>
<p>You acknowledge and agree that we provide access to such tools “as-is” and “as available”
    without any warranties, representations or conditions of any kind and without any
    endorsement. We shall have no liability whatsoever arising from or relating to your use of
    optional third-party tools.</p>
<p>Any use by you of optional tools offered through the site is entirely at your own risk and
    discretion and you should ensure that you are familiar with and approve of the terms on
    which tools are provided by the relevant third-party provider(s).</p>
<p>We may also, in the future, offer new services and/or features through the website
    (including, the release of new tools and resources). Such new features and/or services shall
    also be subject to these Terms of Service.</p>
<h4>Third-Party Links</h4>
<p>Certain content, products and services available via our Service may include materials from
    third-parties.</p>
<p>Third-party links on this site may direct you to third-party websites that are not affiliated
    with us. We are not responsible for examining or evaluating the content or accuracy and we
    do not warrant and will not have any liability or responsibility for any third-party materials
    or websites, or for any other materials, products, or services of third-parties.</p>
<p>We are not liable for any harm or damages related to the purchase or use of goods, services,
    resources, content, or any other transactions made in connection with any third-party
    websites. Please review carefully the third-party\'s policies and practices and make sure you
    understand them before you engage in any transaction. Complaints, claims, concerns, or
    questions regarding third-party products should be directed to the third-party.</p>
<h4>User Comments, Feedback and Other Submissions</h4>
<p>If, at our request, you send certain specific submissions (for example contest entries) or
    without a request from us you send creative ideas, suggestions, proposals, plans, or other
    materials, whether online, by email, by postal mail, or otherwise (collectively, \'comments\'),
    you agree that we may, at any time, without restriction, edit, copy, publish, distribute,
    translate and otherwise use, in any medium, any comments that you forward to us. We are
    and shall be under no obligation to (1) maintain any comments in confidence; (2) pay
    compensation for any comments; or (3) respond to any comments.</p>
<p>We may, but have no obligation to, monitor, edit or remove content that we determine in
    our sole discretion is unlawful, offensive, threatening, libelous, defamatory, pornographic,
    obscene or otherwise objectionable or violates any party’s intellectual property or these
    Terms of Service.</p>
<p>You agree that your comments will not violate any right of any third-party, including
    copyright, trademark, privacy, personality or other personal or proprietary right. You
    further agree that your comments will not contain libelous or otherwise unlawful, abusive
    or obscene material, or contain any computer virus or other malware that could in any way
    affect the operation of the Service or any related website. You may not use a false e-mail
    address, pretend to be someone other than yourself or otherwise mislead us, or
    third-parties as to the origin of any comments. You are solely responsible for any
    comments you make and their accuracy. We take no responsibility and assume no liability
    for any comments posted by you or any third-party.</p>
<h4>Personal Information</h4>
<p>Your submission of personal information through our website or mobile app is governed
    by our Privacy Policy. For more details, see our Privacy Policy.</p>
<h4>Errors, Inaccuracies and Omissions</h4>
<p>Occasionally there may be information on our site or in the Service that contains
    typographical errors, inaccuracies or omissions that may relate to product descriptions,
    pricing, promotions, offers, product shipping charges, transit times and availability. We
    reserve the right to correct any errors, inaccuracies or omissions, and to change or update
    information or cancel orders if any information in the Service or on any related website is
    inaccurate at any time without prior notice (including after you have submitted your
    order).</p>
<p>We undertake no obligation to update, amend or clarify information in the Service or on
    any related website, including without limitation, pricing information, except as required
    by law. No specified update or refresh date applied in the Service or on any related website,
    should be taken to indicate that all information in the Service or on any related website has
    been modified or updated.</p>
<h4>Prohibited Uses</h4>
<p>In addition to other prohibitions as set forth in the Terms of Service, you are prohibited
    from using the site or its content: (a) for any unlawful purpose; (b) to solicit others to
    perform or participate in any unlawful acts; (c) to violate any international, federal,
    provincial or state regulations, rules, laws, or local ordinances; (d) to infringe upon or
    violate our intellectual property rights or the intellectual property rights of others; (e) to
    harass, abuse, insult, harm, defame, slander, disparage, intimidate, or discriminate based on
    gender, sexual orientation, religion, ethnicity, race, age, national origin, or disability; (f) to
    submit false or misleading information; (g) to upload or transmit viruses or any other type
    of malicious code that will or may be used in any way that will affect the functionality or
    operation of the Service or of any related website, other websites, or the Internet; (h) to
    collect or track the personal information of others; (i) to spam, phish, pharm, pretext,
    spider, crawl, or scrape; (j) for any obscene or immoral purpose; or (k) to interfere with or
    circumvent the security features of the Service or any related website, other websites, or
    the Internet. We reserve the right to terminate your use of the Service or any related
    website for violating any of the prohibited uses.</p>
<h4>Disclaimer of Warranties; Limitation of Liability</h4>
<p>We do not guarantee, represent or warrant that your use of our service will be
    uninterrupted, timely, secure or error-free.</p>
<p>We do not warrant that the results that may be obtained from the use of the service will be
    accurate or reliable.</p>
<p>You agree that from time to time we may remove the service for indefinite periods of time
    or cancel the service at any time, without notice to you.</p>
<p>You expressly agree that your use of, or inability to use, the service is at your sole risk. The
    service and all products and services delivered to you through the service are (except as
    expressly stated by us) provided \'as is\' and \'as available\' for your use, without any
    representation, warranties or conditions of any kind, either express or implied, including
    all implied warranties or conditions of merchantability, merchantable quality, fitness for a
    particular purpose, durability, title, and non-infringement.</p>
<p>In no case shall Pocket Yearbook, LLC., our directors, officers, employees, affiliates, agents,
    contractors, interns, suppliers, service providers or licensors be liable for any injury, loss,
    claim, or any direct, indirect, incidental, punitive, special, or consequential damages of any
    kind, including, without limitation lost profits, lost revenue, lost savings, loss of data,
    replacement costs, or any similar damages, whether based in contract, tort (including
    negligence), strict liability or otherwise, arising from your use of any of the service or any
    products procured using the service, or for any other claim related in any way to your use
    of the service or any product, including, but not limited to, any errors or omissions in any
    content, or any loss or damage of any kind incurred as a result of the use of the service or
    any content (or product) posted, transmitted, or otherwise made available via the service,
    even if advised of their possibility. Because some states or jurisdictions do not allow the
    exclusion or the limitation of liability for consequential or incidental damages, in such
    states or jurisdictions, our liability shall be limited to the maximum extent permitted by
    law.</p>
<h4>Indemnification</h4>
<p>You agree to indemnify, defend and hold harmless Pocket Yearbook, LLC. and our parent,
    subsidiaries, affiliates, partners, officers, directors, agents, contractors, licensors, service
    providers, subcontractors, suppliers, interns and employees, harmless from any claim or
    demand, including reasonable attorneys’ fees, made by any third-party due to or arising out
    of your breach of these Terms of Service or the documents they incorporate by reference,
    or your violation of any law or the rights of a third-party.</p>
<h4>Severability</h4>
<p>In the event that any provision of these Terms of Service is determined to be unlawful, void
    or unenforceable, such provision shall nonetheless be enforceable to the fullest extent
    permitted by applicable law, and the unenforceable portion shall be deemed to be severed
    from these Terms of Service, such determination shall not affect the validity and
    enforceability of any other remaining provisions.</p>
<h4>Entire Agreement</h4>
<p>The failure of us to exercise or enforce any right or provision of these Terms of Service
    shall not constitute a waiver of such right or provision.</p>
<p>These Terms of Service and any policies or operating rules posted by us on this site or in
    respect to The Service constitutes the entire agreement and understanding between you
    and us and govern your use of the Service, superseding any prior or contemporaneous
    agreements, communications and proposals, whether oral or written, between you and us
    (including, but not limited to, any prior versions of the Terms of Service).</p>
<p>Any ambiguities in the interpretation of these Terms of Service shall not be construed
    against the drafting party.</p>
<h4>Governing Law</h4>
<p>These Terms of Service and any separate agreements whereby we provide you Services
    shall be governed by and construed in accordance with the laws of the State of Florida.</p>
<h4>Changes to Terms of Service</h4>
<p>You can review the most current version of the Terms of Service at any time at this page.</p>
<p>We reserve the right, at our sole discretion, to update, change or replace any part of these
    Terms of Service by posting updates and changes to our website. It is your responsibility to
    check our website periodically for changes. Your continued use of or access to our website
    or the Service following the posting of any changes to these Terms of Service constitutes
    acceptance of those changes.</p>
<h4>Contact Information</h4>
<p>Questions about the Terms of Service should be sent to us at
    stayconnected@pocketyearbook.com</p>'
		]);
	}

}
