@extends('frontend.frontend_dashboard')

@section('main')
<div class="container py-5">
    <h2 class="mb-4 text-center">Frequently Asked Questions</h2>

    <div class="accordion" id="faqAccordion">

        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    How do I create an account on Gojo Property?
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Click on “Create Account”, fill out your details.
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    How do I list my property for rent or sale?
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Log in as a property owner, go to “Post New Property”, and provide all necessary details and images.
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    Is Gojo Property free to use?
                </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Yes, creating an account and browsing properties is free. Premium features may be added in future.
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="headingFour">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                    How do I contact the property owner?
                </button>
            </h2>
            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Use the chat feature or contact info on the property detail page if made public by the owner.
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
