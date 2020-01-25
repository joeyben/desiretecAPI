<div class="info">
    <i class="fal fa-users"></i>
    <div class="info-detail">
        <div class="up">Familie</div>
        <div class="down">
            <ul>
                @foreach($offer['data']['hotel_attributes'] as $attribute)
                    @if(in_array($attribute, ['action_adventures_parties_fun','attractive_for_couples','attractive_for_singles','attractive_for_singles_w_child','baby_cot','baby_equipment','babysitting','family_friendly_2','kids_disco','pool_for_children','playground_for_children']))
                        <li>{{ trans('hotel.offer.attributes.'.$attribute) }}</li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</div>
<div class="info">
    <i class="fal fa-umbrella-beach"></i>
    <div class="info-detail">
        <div class="up">Strand</div>
        <div class="down">
            <ul>
                @foreach($offer['data']['hotel_attributes'] as $attribute)
                    @if(in_array($attribute, ['hotel_near_beach','sandy_beach','gently_sloping_sandy_beach','direct_beach_access']))
                        <li>{{ trans('hotel.offer.attributes.'.$attribute) }}</li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</div>
<div class="info">
    <i class="fal fa-volleyball-ball"></i>
    <div class="info-detail">
        <div class="up">Sport</div>
        <div class="down">
            <ul>
                @foreach($offer['data']['hotel_attributes'] as $attribute)
                    @if(in_array($attribute, ['bike_mountainbike_rental','buggy_rent','diving_close_to_hotel','hotel_in_hiking_region','own_fitness_facilities','own_squash_court','direct_proximity_ski_lift','own_tennis_court','own_water_slide','great_sports_offer','own_water_sports_facilities','sailing_close_to_hotel','soccer_school','swim_school','surfing_close_to_hotel','winter_sports_ski_area']))
                        <li>{{ trans('hotel.offer.attributes.'.$attribute) }}</li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</div>
<div class="info">
    <i class="fal fa-user-friends"></i>
    <div class="info-detail">
        <div class="up">Adults only</div>
        <div class="down">
            <ul>
                @foreach($offer['data']['hotel_attributes'] as $attribute)
                    @if(in_array($attribute, ['attractive_for_couples','attractive_for_singles','specials_for_newly_married']))
                        <li>{{ trans('hotel.offer.attributes.'.$attribute) }}</li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</div>
<div class="info">
    <i class="fal fa-spa"></i>
    <div class="info-detail">
        <div class="up">Body & Soul</div>
        <div class="down">
            <ul>
                @foreach($offer['data']['hotel_attributes'] as $attribute)
                    @if(in_array($attribute, ['cosmetic_treatments','massages_and_body_treatments','own_sauna_bathing_facilities','own_wellness_facilities','thalasso_treatments']))
                        <li>{{ trans('hotel.offer.attributes.'.$attribute) }}</li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</div>
<div class="info">
    <i class="fal fa-concierge-bell"></i>
    <div class="info-detail">
        <div class="up">Hotel Specials</div>
        <div class="down">
            <ul>
                @foreach($offer['data']['hotel_attributes'] as $attribute)
                    @if(in_array($attribute, ['wlan_available','central_location','city_breaks','medical_service','elegant_deluxe','parking_spaces_available','pets_allowed','quiet_location']))
                        <li>{{ trans('hotel.offer.attributes.'.$attribute) }}</li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</div>