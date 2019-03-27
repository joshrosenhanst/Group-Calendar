/*
  Source: https://github.com/olefirenko/vue-google-autocomplete/blob/master/test/helpers/google_stub.js
*/

export function googleStub() {
  const google = {
    maps: {
      places: {
        Autocomplete: function () {
          return {
            addListener: function () { }
          }
        },
        Geocoder: function () {
          return {
            geocode: function () { }
          }
        }
      },
    }
  };

  return google;
}

export const place_data = {
  "address_components": [
    {
      "long_name": "4",
      "short_name": "4",
      "types": [
        "street_number"
      ]
    },
    {
      "long_name": "Pennsylvania Plaza",
      "short_name": "Pennsylvania Plaza",
      "types": [
        "route"
      ]
    },
    {
      "long_name": "Manhattan",
      "short_name": "Manhattan",
      "types": [
        "sublocality_level_1",
        "sublocality",
        "political"
      ]
    },
    {
      "long_name": "New York",
      "short_name": "New York",
      "types": [
        "locality",
        "political"
      ]
    },
    {
      "long_name": "New York County",
      "short_name": "New York County",
      "types": [
        "administrative_area_level_2",
        "political"
      ]
    },
    {
      "long_name": "New York",
      "short_name": "NY",
      "types": [
        "administrative_area_level_1",
        "political"
      ]
    },
    {
      "long_name": "United States",
      "short_name": "US",
      "types": [
        "country",
        "political"
      ]
    },
    {
      "long_name": "10001",
      "short_name": "10001",
      "types": [
        "postal_code"
      ]
    }
  ],
  "adr_address": "<span class=\"street-address\">4 Pennsylvania Plaza</span>, <span class=\"locality\">New York</span>, <span class=\"region\">NY</span> <span class=\"postal-code\">10001</span>, <span class=\"country-name\">USA</span>",
  "formatted_address": "4 Pennsylvania Plaza, New York, NY 10001, USA",
  "formatted_phone_number": "(212) 465-6741",
  "geometry": {
    "location": {
      lat() {
        return "1234";
      },
      lng() {
        return "1234";
      },
    },
    "viewport": {
      "ma": {
        "j": 40.7490653,
        "l": 40.7522709
      },
      "ga": {
        "j": -73.99636075000001,
        "l": -73.98980374999996
      }
    }
  },
  "icon": "https://maps.gstatic.com/mapfiles/place_api/icons/generic_business-71.png",
  "id": "55e3174d410b31da010030a7dfc0c9819027445a",
  "international_phone_number": "+1 212-465-6741",
  "name": "Madison Square Garden",
  "photos": [
    {
      "height": 3024,
      "html_attributions": [
        "<a href=\"https://maps.google.com/maps/contrib/110013768643640805578/photos\">Annie Rodriguez</a>"
      ],
      "width": 4032
    },
    {
      "height": 2988,
      "html_attributions": [
        "<a href=\"https://maps.google.com/maps/contrib/104103615018374286281/photos\">Santiago Castro</a>"
      ],
      "width": 5312
    },
    {
      "height": 1960,
      "html_attributions": [
        "<a href=\"https://maps.google.com/maps/contrib/101455012218545181575/photos\">José Luis Ocampo</a>"
      ],
      "width": 4032
    },
    {
      "height": 2340,
      "html_attributions": [
        "<a href=\"https://maps.google.com/maps/contrib/106296712750041609814/photos\">Richard Thomas</a>"
      ],
      "width": 4160
    },
    {
      "height": 2578,
      "html_attributions": [
        "<a href=\"https://maps.google.com/maps/contrib/110498804697921173931/photos\">shazad hussain</a>"
      ],
      "width": 9794
    },
    {
      "height": 2620,
      "html_attributions": [
        "<a href=\"https://maps.google.com/maps/contrib/109023263423064992865/photos\">Paulo de Andréa</a>"
      ],
      "width": 4656
    },
    {
      "height": 2160,
      "html_attributions": [
        "<a href=\"https://maps.google.com/maps/contrib/117490121542456888313/photos\">Ruoall Chapman</a>"
      ],
      "width": 3840
    },
    {
      "height": 5312,
      "html_attributions": [
        "<a href=\"https://maps.google.com/maps/contrib/107723153180271216469/photos\">Matthew Dale</a>"
      ],
      "width": 2988
    },
    {
      "height": 4032,
      "html_attributions": [
        "<a href=\"https://maps.google.com/maps/contrib/112604924313937041693/photos\">Vinny Nguyen</a>"
      ],
      "width": 1960
    },
    {
      "height": 3264,
      "html_attributions": [
        "<a href=\"https://maps.google.com/maps/contrib/105706052554684281671/photos\">Guian B</a>"
      ],
      "width": 1836
    }
  ],
  "place_id": "ChIJhRwB-yFawokR5Phil-QQ3zM",
  "plus_code": {
    "compound_code": "Q224+6J New York, United States",
    "global_code": "87G8Q224+6J"
  },
  "rating": 4.6,
  "reference": "ChIJhRwB-yFawokR5Phil-QQ3zM",
  "reviews": [
    {
      "author_name": "Sergio Bencivenga",
      "author_url": "https://www.google.com/maps/contrib/102186662219057931667/reviews",
      "language": "en",
      "profile_photo_url": "https://lh3.googleusercontent.com/-56KzZ3lqyto/AAAAAAAAAAI/AAAAAAAAAAA/ACHi3reNopL7-HeV1Z3egfM3qd4rvnIOWg/s128-c0x00000000-cc-rp-mo-ba3/photo.jpg",
      "rating": 5,
      "relative_time_description": "in the last week",
      "text": "We saw Billy Joel in February and he put on a great show. This was my first time at the Garden and I was shocked at the size. I always thought it was much larger. That's not a bad thing! It's just more intimate than I thought. The concert was great and this was an awesome venue to take in the show. I would definitely see a show or a game at MSG without hesitation.",
      "time": 1553645300
    },
    {
      "author_name": "Bryce Britton",
      "author_url": "https://www.google.com/maps/contrib/104948212384776786604/reviews",
      "language": "en",
      "profile_photo_url": "https://lh4.googleusercontent.com/-gKSMAsJMi5o/AAAAAAAAAAI/AAAAAAAAUhs/IbP8s16oQw4/s128-c0x00000000-cc-rp-mo-ba3/photo.jpg",
      "rating": 5,
      "relative_time_description": "a month ago",
      "text": "Had one of the greatest nights of my life here. The garden is one of the best concert venues bar none, I would recommend going to any concert that you have the chance to go to here. Billy Joel live in concert at Madison square garden is one for the books. Any chance you get to go to Madison square garden I recommend it. What a great opportunity that you won’t forget in a lifetime. From checking in to getting to the seating area everything just went so smooth.",
      "time": 1550645473
    },
    {
      "author_name": "Victor Jung",
      "author_url": "https://www.google.com/maps/contrib/112905136173401849990/reviews",
      "language": "en",
      "profile_photo_url": "https://lh3.googleusercontent.com/-ZeiUjK-GoIE/AAAAAAAAAAI/AAAAAAAAWbM/Kkyb1ibCcY8/s128-c0x00000000-cc-rp-mo-ba4/photo.jpg",
      "rating": 5,
      "relative_time_description": "2 weeks ago",
      "text": "Nothing beats the greatest arena of all time. Suites are great. Staff is attentive. Must see acts. Quick check-in now with Clear. Food selection 100% better than most venues. And if you can get access to Tao Suite, heaven on earth just collided. Never a bad moment.",
      "time": 1552391356
    },
    {
      "author_name": "Angela holmes",
      "author_url": "https://www.google.com/maps/contrib/116895968182179624149/reviews",
      "language": "en",
      "profile_photo_url": "https://lh5.googleusercontent.com/-Bg-CO1VQYUs/AAAAAAAAAAI/AAAAAAAAB0g/TFvrxnXIQMI/s128-c0x00000000-cc-rp-mo-ba4/photo.jpg",
      "rating": 5,
      "relative_time_description": "a week ago",
      "text": "My sister and I took our first trip to NY together to see the Pink concert last year. The staff was wonderful. It's perfectly located near the bus and train station. Food and drink options. Easy to find restrooms and seating was great! Concert was awesome!",
      "time": 1552598297
    },
    {
      "author_name": "Maria Turner",
      "author_url": "https://www.google.com/maps/contrib/105705567755373435409/reviews",
      "language": "en",
      "profile_photo_url": "https://lh3.googleusercontent.com/-R4fbhkXT_aI/AAAAAAAAAAI/AAAAAAAAAAg/uZqzEZ308Jw/s128-c0x00000000-cc-rp-mo/photo.jpg",
      "rating": 3,
      "relative_time_description": "2 weeks ago",
      "text": "I may be a bit biased, but I love Madison Square Garden.\nGood music, cheap drinks, friendly staff, big dance-floor, cool bands, always a fun crowd....never any trouble!\n\nFridays are my favorite nights, Saturdays are cool too!\nMondays bull-riding is hilarious, you won't catch me on it, but you'll definitely catch me on the sidelines wetting myself at everyone else!\n\nIts nice to have such a fun place near where I live!!!!!",
      "time": 1551939373
    }
  ],
  "scope": "GOOGLE",
  "types": [
    "stadium",
    "point_of_interest",
    "establishment"
  ],
  "url": "https://maps.google.com/?cid=3737724789719234788",
  "user_ratings_total": 16065,
  "utc_offset": -240,
  "vicinity": "4 Pennsylvania Plaza, New York",
  "website": "https://www.msg.com/madison-square-garden?cmp=van_thegarden",
  "html_attributions": []
};