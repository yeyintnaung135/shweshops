@extends('layouts.frontend.frontend')
@section('content')
    @include('layouts.frontend.allpart.for_mobile')
    {{--MENU--}}
    @include('layouts.frontend.allpart.upper_menu')
    @include('layouts.frontend.allpart.menu')
    {{-- @include('layouts.frontend.allpart.mobile_search', ['display' => "hide"]) --}}
    {{-- end Menu--}}

    <div class=" my-5 px-lg-5 px-md-3 px-2">
        <div class="mb-5">
            <h3 class="mb-4"><strong>Terms and Conditions</strong></h3>
            <div>
                <p>These Terms and Conditions (“Terms”, “Terms and Conditions”) govern your relationship with
                    https://creativethemes.com website (the “Service”) operated by CreativeThemes (“us”, “we”, or
                    “our”).</p>
                <p>Please read these Terms and Conditions carefully before using the Service.</p>
                <p>Your access to and use of the Service is conditioned on your acceptance of and compliance with these
                    Terms.
                    These Terms apply to all visitors, users and others who access or use the Service.</p>
                <p>By accessing or using the Service you agree to be bound by these Terms. If you disagree with any part
                    of the
                    terms then you may not access the Service.</p>
            </div>
        </div>
        <div class="mb-5">
            <h3 class="mb-4"><strong>License Usage</strong></h3>
            <div>
                <p>1. We will provide support to the original customer/license-owner with a legitimate license key, and
                    consider any other uses of this license key for support queries as fraudulent.</p>
                <p>2. It is not allowed to bundle our product(s) in a website where you have no significant part in its
                    design and development nor resell it as a commercial “as is” license or product.</p>
                <p>3. If you are interested to resell or use our product in a WaaS business model please read this
                    first. </p>
                <p>4. The lifetime license/package is valid for the lifetime of the product itself.</p>
            </div>
        </div>
        <div class="mb-5">
            <h3 class="mb-4"><strong>Copyright Policy</strong></h3>
            <div>
                <p>We respect the intellectual property rights of others. It is our policy to respond to any claim that
                    Content posted on the Service infringes the copyright or other intellectual property infringement
                    (“Infringement”) of any person.</p>
                <p>If you are a copyright owner, or authorized on behalf of one, and you believe that the copyrighted
                    work has been copied in a way that constitutes copyright infringement that is taking place through
                    the Service, you must submit your notice in writing to the attention of “Copyright Infringement” of
                    hq@creativethemes.com and include in your notice a detailed description of the alleged
                    Infringement.</p>
                <p>You may be held accountable for damages (including costs and attorneys’ fees) for misrepresenting
                    that any Content is infringing your copyright.</p>
            </div>
        </div>
        <div class="mb-5">
            <h3 class="mb-4"><strong>Links To Other Web Sites</strong></h3>
            <div>
                <p>Our Service may contain links to third-party web sites or services that are not owned or controlled
                    by CreativeThemes.</p>
                <p>CreativeThemes has no control over, and assumes no responsibility for, the content, privacy policies,
                    or practices of any third party web sites or services. You further acknowledge and agree that
                    CreativeThemes shall not be responsible or liable, directly or indirectly, for any damage or loss
                    caused or alleged to be caused by or in connection with use of or reliance on any such content,
                    goods or services available on or through any such web sites or services.</p>
                <p>We strongly advise you to read the terms and conditions and privacy policies of any third-party web
                    sites or services that you visit.</p>
            </div>
        </div>
        <div class="mb-5">
            <h3 class="mb-4"><strong>Governing Law</strong></h3>
            <div>
                <p>These Terms shall be governed and construed in accordance with the laws of Moldova, without regard to
                    its conflict of law provisions.</p>
                <p>Our failure to enforce any right or provision of these Terms will not be considered a waiver of those
                    rights. If any provision of these Terms is held to be invalid or unenforceable by a court, the
                    remaining provisions of these Terms will remain in effect. These Terms constitute the entire
                    agreement between us regarding our Service, and supersede and replace any prior agreements we might
                    have between us regarding the Service.</p>
            </div>
        </div>
        <div class="mb-5">
            <h3 class="mb-4"><strong>Changes</strong></h3>
            <div>
                <p>We reserve the right, at our sole discretion, to modify or replace these Terms at any time. If a
                    revision is material we will try to provide at least 30 days notice prior to any new terms taking
                    effect. What constitutes a material change will be determined at our sole discretion.</p>
                <p>By continuing to access or use our Service after those revisions become effective, you agree to be
                    bound by the revised terms. If you do not agree to the new terms, please stop using the Service.</p>
            </div>
        </div>
        <div class="mb-5">
            <h3 class="mb-4"><strong>Contact Us</strong></h3>
            <div>
                <p>If you have any questions about these terms, please contact us by email – admin@shweshops.com</p>
            </div>
        </div>
    </div>

    <div class="pt-5">
        @include('layouts.frontend.allpart.footer')
    </div>

    {{--    <!-- .site-content-contain -->--}}
    <div class="ftc-close-popup"></div>
    @include('layouts.frontend.allpart.mobile_footer')
    {{-- <div id="to-top" class="scroll-button">
    <a class="" href="javascript:void(0)" title="Back to Top">Back to Top</a>
    </div> --}}
    <div id="to-top" class="scroll-button">
        <a class="" onclick="scrollToTop()" title="Back to Top">Back to Top</a>
    </div>
    <div class="popupshadow" style="display:none"></div>
@endsection
