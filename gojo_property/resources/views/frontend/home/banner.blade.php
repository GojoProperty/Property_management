 @php
     $states = App\Models\State::latest()->get();
     $ptypes = App\Models\PropertyType::latest()->get();

 @endphp

 <section class="banner-section"
     style="background-image: url({{ asset('frontend/assets/images/banner/banner-1.jpg') }});">
     <div class="auto-container">
         <div class="inner-container">
             <div class="content-box centred">
                 <h2>Create Lasting Wealth Through Gojo Property</h2>
                 <p>The greatest platform to find your dream neighborhood.</p>
             </div>

         </div>
     </div>
 </section>
