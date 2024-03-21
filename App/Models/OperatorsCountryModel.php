<?php
namespace Hitek\Slimez\App\Models;

class OperatorsCountryModel{
    static $country = '[
        {
            "isoName": "AF",
            "name": "Afghanistan",
            "continent": "Asia",
            "currencyCode": "AFN",
            "currencyName": "Afghan Afghani",
            "currencySymbol": "؋",
            "flag": "https://s3.amazonaws.com/rld-flags/af.svg",
            "callingCodes": [
                "+93"
            ]
        },
        {
            "isoName": "AL",
            "name": "Albania",
            "continent": "Europe",
            "currencyCode": "ALL",
            "currencyName": "Albanian Lek",
            "currencySymbol": "Lek",
            "flag": "https://s3.amazonaws.com/rld-flags/al.svg",
            "callingCodes": [
                "+355"
            ]
        },
        {
            "isoName": "DZ",
            "name": "Algeria",
            "continent": "Africa",
            "currencyCode": "DZD",
            "currencyName": "Algerian Dinar",
            "currencySymbol": "د.ج.‏",
            "flag": "https://s3.amazonaws.com/rld-flags/dz.svg",
            "callingCodes": [
                "+213"
            ]
        },
        {
            "isoName": "AS",
            "name": "American Samoa",
            "continent": "Oceania",
            "currencyCode": "USD",
            "currencyName": "US Dollar",
            "currencySymbol": "$",
            "flag": "https://s3.amazonaws.com/rld-flags/as.svg",
            "callingCodes": [
                "+1684"
            ]
        },
        {
            "isoName": "AO",
            "name": "Angola",
            "continent": "Africa",
            "currencyCode": "AOA",
            "currencyName": "Angolan Kwanza",
            "currencySymbol": "AOA",
            "flag": "https://s3.amazonaws.com/rld-flags/ao.svg",
            "callingCodes": [
                "+244"
            ]
        },
        {
            "isoName": "AI",
            "name": "Anguilla",
            "continent": "North America",
            "currencyCode": "XCD",
            "currencyName": "East Caribbean Dollar",
            "currencySymbol": "XCD",
            "flag": "https://s3.amazonaws.com/rld-flags/ai.svg",
            "callingCodes": [
                "+1264"
            ]
        },
        {
            "isoName": "AG",
            "name": "Antigua and Barbuda",
            "continent": "North America",
            "currencyCode": "XCD",
            "currencyName": "East Caribbean Dollar",
            "currencySymbol": "XCD",
            "flag": "https://s3.amazonaws.com/rld-flags/ag.svg",
            "callingCodes": [
                "+1268"
            ]
        },
        {
            "isoName": "AR",
            "name": "Argentina",
            "continent": "South America",
            "currencyCode": "ARS",
            "currencyName": "Argentine Peso",
            "currencySymbol": "$",
            "flag": "https://s3.amazonaws.com/rld-flags/ar.svg",
            "callingCodes": [
                "+54"
            ]
        },
        {
            "isoName": "AM",
            "name": "Armenia",
            "continent": "Asia",
            "currencyCode": "AMD",
            "currencyName": "Armenian Dram",
            "currencySymbol": "դր.",
            "flag": "https://s3.amazonaws.com/rld-flags/am.svg",
            "callingCodes": [
                "+374"
            ]
        },
        {
            "isoName": "AW",
            "name": "Aruba",
            "continent": "North America",
            "currencyCode": "AWG",
            "currencyName": "Aruban Florin",
            "currencySymbol": "AWG",
            "flag": "https://s3.amazonaws.com/rld-flags/aw.svg",
            "callingCodes": [
                "+297"
            ]
        },
        {
            "isoName": "BS",
            "name": "Bahamas",
            "continent": "North America",
            "currencyCode": "BSD",
            "currencyName": "Bahamian Dollar",
            "currencySymbol": "$",
            "flag": "https://s3.amazonaws.com/rld-flags/bs.svg",
            "callingCodes": [
                "+1242"
            ]
        },
        {
            "isoName": "BH",
            "name": "Bahrain",
            "continent": "Asia",
            "currencyCode": "BHD",
            "currencyName": "Bahraini Dinar",
            "currencySymbol": "د.ب.‏",
            "flag": "https://s3.amazonaws.com/rld-flags/bh.svg",
            "callingCodes": [
                "+973"
            ]
        },
        {
            "isoName": "BD",
            "name": "Bangladesh",
            "continent": "Asia",
            "currencyCode": "BDT",
            "currencyName": "Bangladeshi Taka",
            "currencySymbol": "৳",
            "flag": "https://s3.amazonaws.com/rld-flags/bd.svg",
            "callingCodes": [
                "+880"
            ]
        },
        {
            "isoName": "BB",
            "name": "Barbados",
            "continent": "North America",
            "currencyCode": "BBD",
            "currencyName": "Barbadian Dollar",
            "currencySymbol": "$",
            "flag": "https://s3.amazonaws.com/rld-flags/bb.svg",
            "callingCodes": [
                "+1246"
            ]
        },
        {
            "isoName": "BZ",
            "name": "Belize",
            "continent": "North America",
            "currencyCode": "BZD",
            "currencyName": "Belize Dollar",
            "currencySymbol": "$",
            "flag": "https://s3.amazonaws.com/rld-flags/bz.svg",
            "callingCodes": [
                "+501"
            ]
        },
        {
            "isoName": "BJ",
            "name": "Benin",
            "continent": "Africa",
            "currencyCode": "XOF",
            "currencyName": "CFA Franc BCEAO",
            "currencySymbol": "CFA",
            "flag": "https://s3.amazonaws.com/rld-flags/bj.svg",
            "callingCodes": [
                "+229"
            ]
        },
        {
            "isoName": "BM",
            "name": "Bermuda",
            "continent": "North America",
            "currencyCode": "BMD",
            "currencyName": "Bermudan Dollar",
            "currencySymbol": "BMD",
            "flag": "https://s3.amazonaws.com/rld-flags/bm.svg",
            "callingCodes": [
                "+1441"
            ]
        },
        {
            "isoName": "BO",
            "name": "Bolivia",
            "continent": "South America",
            "currencyCode": "BOB",
            "currencyName": "Bolivian Boliviano",
            "currencySymbol": "Bs",
            "flag": "https://s3.amazonaws.com/rld-flags/bo.svg",
            "callingCodes": [
                "+591"
            ]
        },
        {
            "isoName": "BW",
            "name": "Botswana",
            "continent": "Africa",
            "currencyCode": "BWP",
            "currencyName": "Botswanan Pula",
            "currencySymbol": "P",
            "flag": "https://s3.amazonaws.com/rld-flags/bw.svg",
            "callingCodes": [
                "+267"
            ]
        },
        {
            "isoName": "BR",
            "name": "Brazil",
            "continent": "South America",
            "currencyCode": "BRL",
            "currencyName": "Brazilian Real",
            "currencySymbol": "R$",
            "flag": "https://s3.amazonaws.com/rld-flags/br.svg",
            "callingCodes": [
                "+55"
            ]
        },
        {
            "isoName": "VG",
            "name": "British Virgin Islands",
            "continent": "North America",
            "currencyCode": "USD",
            "currencyName": "US Dollar",
            "currencySymbol": "$",
            "flag": "https://s3.amazonaws.com/rld-flags/vg.svg",
            "callingCodes": [
                "+1284"
            ]
        },
        {
            "isoName": "BF",
            "name": "Burkina Faso",
            "continent": "Africa",
            "currencyCode": "XOF",
            "currencyName": "CFA Franc BCEAO",
            "currencySymbol": "CFA",
            "flag": "https://s3.amazonaws.com/rld-flags/bf.svg",
            "callingCodes": [
                "+226"
            ]
        },
        {
            "isoName": "BI",
            "name": "Burundi",
            "continent": "Africa",
            "currencyCode": "BIF",
            "currencyName": "Burundian Franc",
            "currencySymbol": "FBu",
            "flag": "https://s3.amazonaws.com/rld-flags/bi.svg",
            "callingCodes": [
                "+257"
            ]
        },
        {
            "isoName": "KH",
            "name": "Cambodia",
            "continent": "Asia",
            "currencyCode": "USD",
            "currencyName": "US Dollar",
            "currencySymbol": "$",
            "flag": "https://s3.amazonaws.com/rld-flags/kh.svg",
            "callingCodes": [
                "+855"
            ]
        },
        {
            "isoName": "CM",
            "name": "Cameroon",
            "continent": "Africa",
            "currencyCode": "XAF",
            "currencyName": "CFA Franc BEAC",
            "currencySymbol": "FCFA",
            "flag": "https://s3.amazonaws.com/rld-flags/cm.svg",
            "callingCodes": [
                "+237"
            ]
        },
        {
            "isoName": "CA",
            "name": "Canada",
            "continent": "North America",
            "currencyCode": "CAD",
            "currencyName": "Canadian Dollar",
            "currencySymbol": "$",
            "flag": "https://s3.amazonaws.com/rld-flags/ca.svg",
            "callingCodes": [
                "+1"
            ]
        },
        {
            "isoName": "CV",
            "name": "Cape Verde",
            "continent": "Africa",
            "currencyCode": "CVE",
            "currencyName": "Cape Verdean Escudo",
            "currencySymbol": "CV$",
            "flag": "https://s3.amazonaws.com/rld-flags/cv.svg",
            "callingCodes": [
                "+238"
            ]
        },
        {
            "isoName": "KY",
            "name": "Cayman Islands",
            "continent": "North America",
            "currencyCode": "KYD",
            "currencyName": "Cayman Islands Dollar",
            "currencySymbol": "KYD",
            "flag": "https://s3.amazonaws.com/rld-flags/ky.svg",
            "callingCodes": [
                "+1345"
            ]
        },
        {
            "isoName": "CF",
            "name": "Central African Republic",
            "continent": "Africa",
            "currencyCode": "XAF",
            "currencyName": "CFA Franc BEAC",
            "currencySymbol": "FCFA",
            "flag": "https://s3.amazonaws.com/rld-flags/cf.svg",
            "callingCodes": [
                "+236"
            ]
        },
        {
            "isoName": "CL",
            "name": "Chile",
            "continent": "South America",
            "currencyCode": "CLP",
            "currencyName": "Chilean Peso",
            "currencySymbol": "$",
            "flag": "https://s3.amazonaws.com/rld-flags/cl.svg",
            "callingCodes": [
                "+56"
            ]
        },
        {
            "isoName": "CN",
            "name": "China",
            "continent": "Asia",
            "currencyCode": "CNY",
            "currencyName": "Chinese Yuan",
            "currencySymbol": "CN¥",
            "flag": "https://s3.amazonaws.com/rld-flags/cn.svg",
            "callingCodes": [
                "+86"
            ]
        },
        {
            "isoName": "CO",
            "name": "Colombia",
            "continent": "South America",
            "currencyCode": "COP",
            "currencyName": "Colombian Peso",
            "currencySymbol": "$",
            "flag": "https://s3.amazonaws.com/rld-flags/co.svg",
            "callingCodes": [
                "+57"
            ]
        },
        {
            "isoName": "CG",
            "name": "Congo",
            "continent": "Africa",
            "currencyCode": "XAF",
            "currencyName": "CFA Franc BEAC",
            "currencySymbol": "FCFA",
            "flag": "https://s3.amazonaws.com/rld-flags/cg.svg",
            "callingCodes": [
                "+242"
            ]
        },
        {
            "isoName": "CR",
            "name": "Costa Rica",
            "continent": "North America",
            "currencyCode": "CRC",
            "currencyName": "Costa Rican Colón",
            "currencySymbol": "₡",
            "flag": "https://s3.amazonaws.com/rld-flags/cr.svg",
            "callingCodes": [
                "+506"
            ]
        },
        {
            "isoName": "CI",
            "name": "Côte d\'Ivoire",
            "continent": "Africa",
            "currencyCode": "XOF",
            "currencyName": "CFA Franc BCEAO",
            "currencySymbol": "CFA",
            "flag": "https://s3.amazonaws.com/rld-flags/ci.svg",
            "callingCodes": [
                "+225"
            ]
        },
        {
            "isoName": "CU",
            "name": "Cuba",
            "continent": "North America",
            "currencyCode": "CUP",
            "currencyName": "Cuban Peso",
            "currencySymbol": "₱",
            "flag": "https://s3.amazonaws.com/rld-flags/cu.svg",
            "callingCodes": [
                "+53"
            ]
        },
        {
            "isoName": "CY",
            "name": "Cyprus",
            "continent": "Asia",
            "currencyCode": "EUR",
            "currencyName": "Euro",
            "currencySymbol": "€",
            "flag": "https://s3.amazonaws.com/rld-flags/cy.svg",
            "callingCodes": [
                "+357"
            ]
        },
        {
            "isoName": "DM",
            "name": "Dominica",
            "continent": "North America",
            "currencyCode": "XCD",
            "currencyName": "East Caribbean Dollar",
            "currencySymbol": "XCD",
            "flag": "https://s3.amazonaws.com/rld-flags/dm.svg",
            "callingCodes": [
                "+1767"
            ]
        },
        {
            "isoName": "DO",
            "name": "Dominican Republic",
            "continent": "North America",
            "currencyCode": "DOP",
            "currencyName": "Dominican Peso",
            "currencySymbol": "RD$",
            "flag": "https://s3.amazonaws.com/rld-flags/do.svg",
            "callingCodes": [
                "+1829",
                "+1849",
                "+1809"
            ]
        },
        {
            "isoName": "EC",
            "name": "Ecuador",
            "continent": "South America",
            "currencyCode": "USD",
            "currencyName": "US Dollar",
            "currencySymbol": "$",
            "flag": "https://s3.amazonaws.com/rld-flags/ec.svg",
            "callingCodes": [
                "+593"
            ]
        },
        {
            "isoName": "EG",
            "name": "Egypt",
            "continent": "Africa",
            "currencyCode": "EGP",
            "currencyName": "Egyptian Pound",
            "currencySymbol": "ج.م.‏",
            "flag": "https://s3.amazonaws.com/rld-flags/eg.svg",
            "callingCodes": [
                "+20"
            ]
        },
        {
            "isoName": "SV",
            "name": "El Salvador",
            "continent": "North America",
            "currencyCode": "USD",
            "currencyName": "US Dollar",
            "currencySymbol": "$",
            "flag": "https://s3.amazonaws.com/rld-flags/sv.svg",
            "callingCodes": [
                "+503"
            ]
        },
        {
            "isoName": "ET",
            "name": "Ethiopia",
            "continent": "Africa",
            "currencyCode": "ETB",
            "currencyName": "Ethiopian Birr",
            "currencySymbol": "Br",
            "flag": "https://s3.amazonaws.com/rld-flags/et.svg",
            "callingCodes": [
                "+251"
            ]
        },
        {
            "isoName": "FJ",
            "name": "Fiji",
            "continent": "Oceania",
            "currencyCode": "FJD",
            "currencyName": "Fijian Dollar",
            "currencySymbol": "$",
            "flag": "https://s3.amazonaws.com/rld-flags/fj.svg",
            "callingCodes": [
                "+679"
            ]
        },
        {
            "isoName": "FR",
            "name": "France",
            "continent": "Europe",
            "currencyCode": "EUR",
            "currencyName": "Euro",
            "currencySymbol": "€",
            "flag": "https://s3.amazonaws.com/rld-flags/fr.svg",
            "callingCodes": [
                "+33"
            ]
        },
        {
            "isoName": "GM",
            "name": "Gambia",
            "continent": "Africa",
            "currencyCode": "GMD",
            "currencyName": "Gambian Dalasi",
            "currencySymbol": "GMD",
            "flag": "https://s3.amazonaws.com/rld-flags/gm.svg",
            "callingCodes": [
                "+220"
            ]
        },
        {
            "isoName": "GE",
            "name": "Georgia",
            "continent": "Asia",
            "currencyCode": "GEL",
            "currencyName": "Georgian Lari",
            "currencySymbol": "ლ",
            "flag": "https://s3.amazonaws.com/rld-flags/ge.svg",
            "callingCodes": [
                "+995"
            ]
        },
        {
            "isoName": "DE",
            "name": "Germany",
            "continent": "Europe",
            "currencyCode": "EUR",
            "currencyName": "Euro",
            "currencySymbol": "€",
            "flag": "https://s3.amazonaws.com/rld-flags/de.svg",
            "callingCodes": [
                "+49"
            ]
        },
        {
            "isoName": "GH",
            "name": "Ghana",
            "continent": "Africa",
            "currencyCode": "GHS",
            "currencyName": "Ghanaian Cedi",
            "currencySymbol": "GH₵",
            "flag": "https://s3.amazonaws.com/rld-flags/gh.svg",
            "callingCodes": [
                "+233"
            ]
        },
        {
            "isoName": "GD",
            "name": "Grenada",
            "continent": "North America",
            "currencyCode": "XCD",
            "currencyName": "East Caribbean Dollar",
            "currencySymbol": "XCD",
            "flag": "https://s3.amazonaws.com/rld-flags/gd.svg",
            "callingCodes": [
                "+1473"
            ]
        },
        {
            "isoName": "GT",
            "name": "Guatemala",
            "continent": "North America",
            "currencyCode": "GTQ",
            "currencyName": "Guatemalan Quetzal",
            "currencySymbol": "Q",
            "flag": "https://s3.amazonaws.com/rld-flags/gt.svg",
            "callingCodes": [
                "+502"
            ]
        },
        {
            "isoName": "GN",
            "name": "Guinea Conakry",
            "continent": "Africa",
            "currencyCode": "GNF",
            "currencyName": "Guinean Franc",
            "currencySymbol": "FG",
            "flag": "https://s3.amazonaws.com/rld-flags/gn.svg",
            "callingCodes": [
                "+224"
            ]
        },
        {
            "isoName": "GW",
            "name": "Guinea-Bissau",
            "continent": "Africa",
            "currencyCode": "XOF",
            "currencyName": "CFA Franc BCEAO",
            "currencySymbol": "CFA",
            "flag": "https://s3.amazonaws.com/rld-flags/gw.svg",
            "callingCodes": [
                "+245"
            ]
        },
        {
            "isoName": "GY",
            "name": "Guyana",
            "continent": "South America",
            "currencyCode": "GYD",
            "currencyName": "Guyanaese Dollar",
            "currencySymbol": "GYD",
            "flag": "https://s3.amazonaws.com/rld-flags/gy.svg",
            "callingCodes": [
                "+592"
            ]
        },
        {
            "isoName": "HT",
            "name": "Haiti",
            "continent": "North America",
            "currencyCode": "HTG",
            "currencyName": "Haitian Gourde",
            "currencySymbol": "HTG",
            "flag": "https://s3.amazonaws.com/rld-flags/ht.svg",
            "callingCodes": [
                "+509"
            ]
        },
        {
            "isoName": "HN",
            "name": "Honduras",
            "continent": "North America",
            "currencyCode": "HNL",
            "currencyName": "Honduran Lempira",
            "currencySymbol": "L",
            "flag": "https://s3.amazonaws.com/rld-flags/hn.svg",
            "callingCodes": [
                "+504"
            ]
        },
        {
            "isoName": "IN",
            "name": "India",
            "continent": "Asia",
            "currencyCode": "INR",
            "currencyName": "Indian Rupee",
            "currencySymbol": "₹",
            "flag": "https://s3.amazonaws.com/rld-flags/in.svg",
            "callingCodes": [
                "+91"
            ]
        },
        {
            "isoName": "ID",
            "name": "Indonesia",
            "continent": "Asia",
            "currencyCode": "IDR",
            "currencyName": "Indonesian Rupiah",
            "currencySymbol": "Rp",
            "flag": "https://s3.amazonaws.com/rld-flags/id.svg",
            "callingCodes": [
                "+62"
            ]
        },
        {
            "isoName": "IQ",
            "name": "Iraq",
            "continent": "Asia",
            "currencyCode": "IQD",
            "currencyName": "Iraqi Dinar",
            "currencySymbol": "د.ع.‏",
            "flag": "https://s3.amazonaws.com/rld-flags/iq.svg",
            "callingCodes": [
                "+964"
            ]
        },
        {
            "isoName": "IT",
            "name": "Italy",
            "continent": "Europe",
            "currencyCode": "EUR",
            "currencyName": "Euro",
            "currencySymbol": "€",
            "flag": "https://s3.amazonaws.com/rld-flags/it.svg",
            "callingCodes": [
                "+39"
            ]
        },
        {
            "isoName": "JM",
            "name": "Jamaica",
            "continent": "North America",
            "currencyCode": "JMD",
            "currencyName": "Jamaican Dollar",
            "currencySymbol": "J$",
            "flag": "https://s3.amazonaws.com/rld-flags/jm.svg",
            "callingCodes": [
                "+1876"
            ]
        },
        {
            "isoName": "JO",
            "name": "Jordan",
            "continent": "Asia",
            "currencyCode": "JOD",
            "currencyName": "Jordanian Dinar",
            "currencySymbol": "د.أ.‏",
            "flag": "https://s3.amazonaws.com/rld-flags/jo.svg",
            "callingCodes": [
                "+962"
            ]
        },
        {
            "isoName": "KZ",
            "name": "Kazakhstan",
            "continent": "Asia",
            "currencyCode": "KZT",
            "currencyName": "Kazakhstani Tenge",
            "currencySymbol": "тңг.",
            "flag": "https://s3.amazonaws.com/rld-flags/kz.svg",
            "callingCodes": [
                "+7"
            ]
        },
        {
            "isoName": "KE",
            "name": "Kenya",
            "continent": "Africa",
            "currencyCode": "KES",
            "currencyName": "Kenyan Shilling",
            "currencySymbol": "Ksh",
            "flag": "https://s3.amazonaws.com/rld-flags/ke.svg",
            "callingCodes": [
                "+254"
            ]
        },
        {
            "isoName": "KW",
            "name": "Kuwait",
            "continent": "Asia",
            "currencyCode": "KWD",
            "currencyName": "Kuwaiti Dinar",
            "currencySymbol": "د.ك.‏",
            "flag": "https://s3.amazonaws.com/rld-flags/kw.svg",
            "callingCodes": [
                "+965"
            ]
        },
        {
            "isoName": "KG",
            "name": "Kyrgyzstan",
            "continent": "Asia",
            "currencyCode": "KGS",
            "currencyName": "Kyrgystani Som",
            "currencySymbol": "KGS",
            "flag": "https://s3.amazonaws.com/rld-flags/kg.svg",
            "callingCodes": [
                "+996"
            ]
        },
        {
            "isoName": "LA",
            "name": "Laos",
            "continent": "Asia",
            "currencyCode": "LAK",
            "currencyName": "Laotian Kip",
            "currencySymbol": "LAK",
            "flag": "https://s3.amazonaws.com/rld-flags/la.svg",
            "callingCodes": [
                "+856"
            ]
        },
        {
            "isoName": "LB",
            "name": "Lebanon",
            "continent": "Asia",
            "currencyCode": "LBP",
            "currencyName": "Lebanese Pound",
            "currencySymbol": "ل.ل.‏",
            "flag": "https://s3.amazonaws.com/rld-flags/lb.svg",
            "callingCodes": [
                "+961"
            ]
        },
        {
            "isoName": "LR",
            "name": "Liberia",
            "continent": "Africa",
            "currencyCode": "USD",
            "currencyName": "US Dollar",
            "currencySymbol": "$",
            "flag": "https://s3.amazonaws.com/rld-flags/lr.svg",
            "callingCodes": [
                "+231"
            ]
        },
        {
            "isoName": "MK",
            "name": "Macedonia",
            "continent": "Europe",
            "currencyCode": "MKD",
            "currencyName": "Macedonian Denar",
            "currencySymbol": "MKD",
            "flag": "https://s3.amazonaws.com/rld-flags/mk.svg",
            "callingCodes": [
                "+389"
            ]
        },
        {
            "isoName": "MG",
            "name": "Madagascar",
            "continent": "Africa",
            "currencyCode": "MGA",
            "currencyName": "Malagasy Ariary",
            "currencySymbol": "MGA",
            "flag": "https://s3.amazonaws.com/rld-flags/mg.svg",
            "callingCodes": [
                "+261"
            ]
        },
        {
            "isoName": "MW",
            "name": "Malawi",
            "continent": "Africa",
            "currencyCode": "MWK",
            "currencyName": "Malawian Kwacha",
            "currencySymbol": "MWK",
            "flag": "https://s3.amazonaws.com/rld-flags/mw.svg",
            "callingCodes": [
                "+265"
            ]
        },
        {
            "isoName": "MY",
            "name": "Malaysia",
            "continent": "Asia",
            "currencyCode": "MYR",
            "currencyName": "Malaysian Ringgit",
            "currencySymbol": "RM",
            "flag": "https://s3.amazonaws.com/rld-flags/my.svg",
            "callingCodes": [
                "+60"
            ]
        },
        {
            "isoName": "ML",
            "name": "Mali",
            "continent": "Africa",
            "currencyCode": "XOF",
            "currencyName": "CFA Franc BCEAO",
            "currencySymbol": "CFA",
            "flag": "https://s3.amazonaws.com/rld-flags/ml.svg",
            "callingCodes": [
                "+223"
            ]
        },
        {
            "isoName": "MQ",
            "name": "Martinique",
            "continent": "North America",
            "currencyCode": "EUR",
            "currencyName": "Euro",
            "currencySymbol": "€",
            "flag": "https://s3.amazonaws.com/rld-flags/mq.svg",
            "callingCodes": [
                "+596"
            ]
        },
        {
            "isoName": "MX",
            "name": "Mexico",
            "continent": "North America",
            "currencyCode": "MXN",
            "currencyName": "Mexican Peso",
            "currencySymbol": "$",
            "flag": "https://s3.amazonaws.com/rld-flags/mx.svg",
            "callingCodes": [
                "+52"
            ]
        },
        {
            "isoName": "MD",
            "name": "Moldova",
            "continent": "Europe",
            "currencyCode": "MDL",
            "currencyName": "Moldovan Leu",
            "currencySymbol": "MDL",
            "flag": "https://s3.amazonaws.com/rld-flags/md.svg",
            "callingCodes": [
                "+373"
            ]
        },
        {
            "isoName": "MA",
            "name": "Morocco",
            "continent": "Africa",
            "currencyCode": "MAD",
            "currencyName": "Moroccan Dirham",
            "currencySymbol": "د.م.‏",
            "flag": "https://s3.amazonaws.com/rld-flags/ma.svg",
            "callingCodes": [
                "+212"
            ]
        },
        {
            "isoName": "MZ",
            "name": "Mozambique",
            "continent": "Africa",
            "currencyCode": "MZN",
            "currencyName": "Mozambican Metical",
            "currencySymbol": "MTn",
            "flag": "https://s3.amazonaws.com/rld-flags/mz.svg",
            "callingCodes": [
                "+258"
            ]
        },
        {
            "isoName": "MM",
            "name": "Myanmar",
            "continent": "Asia",
            "currencyCode": "MMK",
            "currencyName": "Myanma Kyat",
            "currencySymbol": "K",
            "flag": "https://s3.amazonaws.com/rld-flags/mm.svg",
            "callingCodes": [
                "+95"
            ]
        },
        {
            "isoName": "NA",
            "name": "Namibia",
            "continent": "Africa",
            "currencyCode": "NAD",
            "currencyName": "Namibian Dollar",
            "currencySymbol": "N$",
            "flag": "https://s3.amazonaws.com/rld-flags/na.svg",
            "callingCodes": [
                "+264"
            ]
        },
        {
            "isoName": "NR",
            "name": "Nauru",
            "continent": "Oceania",
            "currencyCode": "AUD",
            "currencyName": "Australian Dollar",
            "currencySymbol": "$",
            "flag": "https://s3.amazonaws.com/rld-flags/nr.svg",
            "callingCodes": [
                "+674"
            ]
        },
        {
            "isoName": "NP",
            "name": "Nepal",
            "continent": "Asia",
            "currencyCode": "NPR",
            "currencyName": "Nepalese Rupee",
            "currencySymbol": "नेरू",
            "flag": "https://s3.amazonaws.com/rld-flags/np.svg",
            "callingCodes": [
                "+977"
            ]
        },
        {
            "isoName": "NL",
            "name": "Netherlands",
            "continent": "Europe",
            "currencyCode": "EUR",
            "currencyName": "Euro",
            "currencySymbol": "€",
            "flag": "https://s3.amazonaws.com/rld-flags/nl.svg",
            "callingCodes": [
                "+31"
            ]
        },
        {
            "isoName": "AN",
            "name": "Netherlands Antilles",
            "continent": "North America",
            "currencyCode": "ANG",
            "currencyName": "Netherlands Antillean Guilder",
            "currencySymbol": "ƒ",
            "flag": "https://s3.amazonaws.com/rld-flags/ant.svg\n",
            "callingCodes": [
                "+599"
            ]
        },
        {
            "isoName": "NI",
            "name": "Nicaragua",
            "continent": "North America",
            "currencyCode": "NIO",
            "currencyName": "Nicaraguan Córdoba",
            "currencySymbol": "C$",
            "flag": "https://s3.amazonaws.com/rld-flags/ni.svg",
            "callingCodes": [
                "+505"
            ]
        },
        {
            "isoName": "NE",
            "name": "Niger",
            "continent": "Africa",
            "currencyCode": "XOF",
            "currencyName": "CFA Franc BCEAO",
            "currencySymbol": "CFA",
            "flag": "https://s3.amazonaws.com/rld-flags/ne.svg",
            "callingCodes": [
                "+227"
            ]
        },
        {
            "isoName": "NG",
            "name": "Nigeria",
            "continent": "Africa",
            "currencyCode": "NGN",
            "currencyName": "Nigerian Naira",
            "currencySymbol": "₦",
            "flag": "https://s3.amazonaws.com/rld-flags/ng.svg",
            "callingCodes": [
                "+234"
            ]
        },
        {
            "isoName": "OM",
            "name": "Oman",
            "continent": "Asia",
            "currencyCode": "OMR",
            "currencyName": "Omani Rial",
            "currencySymbol": "ر.ع.‏",
            "flag": "https://s3.amazonaws.com/rld-flags/om.svg",
            "callingCodes": [
                "+968"
            ]
        },
        {
            "isoName": "PK",
            "name": "Pakistan",
            "continent": "Asia",
            "currencyCode": "PKR",
            "currencyName": "Pakistani Rupee",
            "currencySymbol": "₨",
            "flag": "https://s3.amazonaws.com/rld-flags/pk.svg",
            "callingCodes": [
                "+92"
            ]
        },
        {
            "isoName": "PS",
            "name": "Palestine",
            "continent": "Asia",
            "currencyCode": "ILS",
            "currencyName": "Israeli New Sheqel",
            "currencySymbol": "₪",
            "flag": "https://s3.amazonaws.com/rld-flags/ps.svg",
            "callingCodes": [
                "+970"
            ]
        },
        {
            "isoName": "PA",
            "name": "Panama",
            "continent": "North America",
            "currencyCode": "USD",
            "currencyName": "US Dollar",
            "currencySymbol": "$",
            "flag": "https://s3.amazonaws.com/rld-flags/pa.svg",
            "callingCodes": [
                "+507"
            ]
        },
        {
            "isoName": "PG",
            "name": "Papua New Guinea",
            "continent": "Oceania",
            "currencyCode": "PGK",
            "currencyName": "Papua New Guinean Kina",
            "currencySymbol": "PGK",
            "flag": "https://s3.amazonaws.com/rld-flags/pg.svg",
            "callingCodes": [
                "+675"
            ]
        },
        {
            "isoName": "PY",
            "name": "Paraguay",
            "continent": "South America",
            "currencyCode": "PYG",
            "currencyName": "Paraguayan Guarani",
            "currencySymbol": "₲",
            "flag": "https://s3.amazonaws.com/rld-flags/py.svg",
            "callingCodes": [
                "+595"
            ]
        },
        {
            "isoName": "PE",
            "name": "Peru",
            "continent": "South America",
            "currencyCode": "PEN",
            "currencyName": "Peruvian Nuevo Sol",
            "currencySymbol": "S/.",
            "flag": "https://s3.amazonaws.com/rld-flags/pe.svg",
            "callingCodes": [
                "+51"
            ]
        },
        {
            "isoName": "PH",
            "name": "Philippines",
            "continent": "Asia",
            "currencyCode": "PHP",
            "currencyName": "Philippine Peso",
            "currencySymbol": "₱",
            "flag": "https://s3.amazonaws.com/rld-flags/ph.svg",
            "callingCodes": [
                "+63"
            ]
        },
        {
            "isoName": "PL",
            "name": "Poland",
            "continent": "Europe",
            "currencyCode": "PLN",
            "currencyName": "Polish Zloty",
            "currencySymbol": "zł",
            "flag": "https://s3.amazonaws.com/rld-flags/pl.svg",
            "callingCodes": [
                "+48"
            ]
        },
        {
            "isoName": "PT",
            "name": "Portugal",
            "continent": "Europe",
            "currencyCode": "EUR",
            "currencyName": "Euro",
            "currencySymbol": "€",
            "flag": "https://s3.amazonaws.com/rld-flags/pt.svg",
            "callingCodes": [
                "+351"
            ]
        },
        {
            "isoName": "PR",
            "name": "Puerto Rico",
            "continent": "North America",
            "currencyCode": "USD",
            "currencyName": "US Dollar",
            "currencySymbol": "$",
            "flag": "https://s3.amazonaws.com/rld-flags/pr.svg",
            "callingCodes": [
                "+1939",
                "+1787"
            ]
        },
        {
            "isoName": "QA",
            "name": "Qatar",
            "continent": "Asia",
            "currencyCode": "QAR",
            "currencyName": "Qatari Rial",
            "currencySymbol": "ر.ق.‏",
            "flag": "https://s3.amazonaws.com/rld-flags/qa.svg",
            "callingCodes": [
                "+974"
            ]
        },
        {
            "isoName": "RO",
            "name": "Romania",
            "continent": "Europe",
            "currencyCode": "EUR",
            "currencyName": "Euro",
            "currencySymbol": "€",
            "flag": "https://s3.amazonaws.com/rld-flags/ro.svg",
            "callingCodes": [
                "+40"
            ]
        },
        {
            "isoName": "RU",
            "name": "Russia",
            "continent": "Europe",
            "currencyCode": "RUB",
            "currencyName": "Russian Ruble",
            "currencySymbol": "руб.",
            "flag": "https://s3.amazonaws.com/rld-flags/ru.svg",
            "callingCodes": [
                "+7"
            ]
        },
        {
            "isoName": "RW",
            "name": "Rwanda",
            "continent": "Africa",
            "currencyCode": "RWF",
            "currencyName": "Rwandan Franc",
            "currencySymbol": "FR",
            "flag": "https://s3.amazonaws.com/rld-flags/rw.svg",
            "callingCodes": [
                "+250"
            ]
        },
        {
            "isoName": "KN",
            "name": "Saint Kitts And Nevis",
            "continent": "North America",
            "currencyCode": "XCD",
            "currencyName": "East Caribbean Dollar",
            "currencySymbol": "XCD",
            "flag": "https://s3.amazonaws.com/rld-flags/kn.svg",
            "callingCodes": [
                "+1869"
            ]
        },
        {
            "isoName": "LC",
            "name": "Saint Lucia",
            "continent": "North America",
            "currencyCode": "XCD",
            "currencyName": "East Caribbean Dollar",
            "currencySymbol": "XCD",
            "flag": "https://s3.amazonaws.com/rld-flags/lc.svg",
            "callingCodes": [
                "+1758"
            ]
        },
        {
            "isoName": "VC",
            "name": "Saint Vincent And The Grenadines",
            "continent": "North America",
            "currencyCode": "XCD",
            "currencyName": "East Caribbean Dollar",
            "currencySymbol": "XCD",
            "flag": "https://s3.amazonaws.com/rld-flags/vc.svg",
            "callingCodes": [
                "+1784"
            ]
        },
        {
            "isoName": "WS",
            "name": "Samoa",
            "continent": "Oceania",
            "currencyCode": "WST",
            "currencyName": "Samoan Tala",
            "currencySymbol": "WST",
            "flag": "https://s3.amazonaws.com/rld-flags/ws.svg",
            "callingCodes": [
                "+685"
            ]
        },
        {
            "isoName": "SA",
            "name": "Saudi Arabia",
            "continent": "Asia",
            "currencyCode": "SAR",
            "currencyName": "Saudi Riyal",
            "currencySymbol": "ر.س.‏",
            "flag": "https://s3.amazonaws.com/rld-flags/sa.svg",
            "callingCodes": [
                "+966"
            ]
        },
        {
            "isoName": "SN",
            "name": "Senegal",
            "continent": "Africa",
            "currencyCode": "XOF",
            "currencyName": "CFA Franc BCEAO",
            "currencySymbol": "CFA",
            "flag": "https://s3.amazonaws.com/rld-flags/sn.svg",
            "callingCodes": [
                "+221"
            ]
        },
        {
            "isoName": "SL",
            "name": "Sierra Leone",
            "continent": "Africa",
            "currencyCode": "SLL",
            "currencyName": "Sierra Leonean Leone",
            "currencySymbol": "SLL",
            "flag": "https://s3.amazonaws.com/rld-flags/sl.svg",
            "callingCodes": [
                "+232"
            ]
        },
        {
            "isoName": "SG",
            "name": "Singapore",
            "continent": "Asia",
            "currencyCode": "SGD",
            "currencyName": "Singapore Dollar",
            "currencySymbol": "$",
            "flag": "https://s3.amazonaws.com/rld-flags/sg.svg",
            "callingCodes": [
                "+65"
            ]
        },
        {
            "isoName": "ZA",
            "name": "South Africa",
            "continent": "Africa",
            "currencyCode": "ZAR",
            "currencyName": "South African Rand",
            "currencySymbol": "R",
            "flag": "https://s3.amazonaws.com/rld-flags/za.svg",
            "callingCodes": [
                "+27"
            ]
        },
        {
            "isoName": "ES",
            "name": "Spain",
            "continent": "Europe",
            "currencyCode": "EUR",
            "currencyName": "Euro",
            "currencySymbol": "€",
            "flag": "https://s3.amazonaws.com/rld-flags/es.svg",
            "callingCodes": [
                "+34"
            ]
        },
        {
            "isoName": "LK",
            "name": "Sri Lanka",
            "continent": "Asia",
            "currencyCode": "LKR",
            "currencyName": "Sri Lankan Rupee",
            "currencySymbol": "SL Re",
            "flag": "https://s3.amazonaws.com/rld-flags/lk.svg",
            "callingCodes": [
                "+94"
            ]
        },
        {
            "isoName": "SR",
            "name": "Suriname",
            "continent": "South America",
            "currencyCode": "SRD",
            "currencyName": "Surinamese Dollar",
            "currencySymbol": "SRD",
            "flag": "https://s3.amazonaws.com/rld-flags/sr.svg",
            "callingCodes": [
                "+597"
            ]
        },
        {
            "isoName": "SZ",
            "name": "Eswatini",
            "continent": "Africa",
            "currencyCode": "SZL",
            "currencyName": "Swazi Lilangeni",
            "currencySymbol": "SZL",
            "flag": "https://s3.amazonaws.com/rld-flags/sz.svg",
            "callingCodes": [
                "+268"
            ]
        },
        {
            "isoName": "TJ",
            "name": "Tajikistan",
            "continent": "Asia",
            "currencyCode": "TJS",
            "currencyName": "Tajikistani Somoni",
            "currencySymbol": "TJS",
            "flag": "https://s3.amazonaws.com/rld-flags/tj.svg",
            "callingCodes": [
                "+992"
            ]
        },
        {
            "isoName": "TZ",
            "name": "Tanzania",
            "continent": "Africa",
            "currencyCode": "TZS",
            "currencyName": "Tanzanian Shilling",
            "currencySymbol": "TSh",
            "flag": "https://s3.amazonaws.com/rld-flags/tz.svg",
            "callingCodes": [
                "+255"
            ]
        },
        {
            "isoName": "TH",
            "name": "Thailand",
            "continent": "Asia",
            "currencyCode": "THB",
            "currencyName": "Thai Baht",
            "currencySymbol": "฿",
            "flag": "https://s3.amazonaws.com/rld-flags/th.svg",
            "callingCodes": [
                "+66"
            ]
        },
        {
            "isoName": "CD",
            "name": "The Democratic Republic Of Congo",
            "continent": "Africa",
            "currencyCode": "USD",
            "currencyName": "US Dollar",
            "currencySymbol": "$",
            "flag": "https://s3.amazonaws.com/rld-flags/cd.svg",
            "callingCodes": [
                "+243"
            ]
        },
        {
            "isoName": "TG",
            "name": "Togo",
            "continent": "Africa",
            "currencyCode": "XOF",
            "currencyName": "CFA Franc BCEAO",
            "currencySymbol": "CFA",
            "flag": "https://s3.amazonaws.com/rld-flags/tg.svg",
            "callingCodes": [
                "+228"
            ]
        },
        {
            "isoName": "TO",
            "name": "Tonga",
            "continent": "Oceania",
            "currencyCode": "TOP",
            "currencyName": "Tongan Pa?anga",
            "currencySymbol": "T$",
            "flag": "https://s3.amazonaws.com/rld-flags/to.svg",
            "callingCodes": [
                "+676"
            ]
        },
        {
            "isoName": "TT",
            "name": "Trinidad and Tobago",
            "continent": "North America",
            "currencyCode": "TTD",
            "currencyName": "Trinidad and Tobago Dollar",
            "currencySymbol": "$",
            "flag": "https://s3.amazonaws.com/rld-flags/tt.svg",
            "callingCodes": [
                "+1868"
            ]
        },
        {
            "isoName": "TN",
            "name": "Tunisia",
            "continent": "Africa",
            "currencyCode": "TND",
            "currencyName": "Tunisian Dinar",
            "currencySymbol": "د.ت.‏",
            "flag": "https://s3.amazonaws.com/rld-flags/tn.svg",
            "callingCodes": [
                "+216"
            ]
        },
        {
            "isoName": "TR",
            "name": "Turkey",
            "continent": "Europe",
            "currencyCode": "TRY",
            "currencyName": "Turkish Lira",
            "currencySymbol": "TL",
            "flag": "https://s3.amazonaws.com/rld-flags/tr.svg",
            "callingCodes": [
                "+90"
            ]
        },
        {
            "isoName": "TC",
            "name": "Turks And Caicos Islands",
            "continent": "North America",
            "currencyCode": "USD",
            "currencyName": "US Dollar",
            "currencySymbol": "$",
            "flag": "https://s3.amazonaws.com/rld-flags/tc.svg",
            "callingCodes": [
                "+1649"
            ]
        },
        {
            "isoName": "UG",
            "name": "Uganda",
            "continent": "Africa",
            "currencyCode": "UGX",
            "currencyName": "Ugandan Shilling",
            "currencySymbol": "USh",
            "flag": "https://s3.amazonaws.com/rld-flags/ug.svg",
            "callingCodes": [
                "+256"
            ]
        },
        {
            "isoName": "UA",
            "name": "Ukraine",
            "continent": "Europe",
            "currencyCode": "UAH",
            "currencyName": "Ukrainian Hryvnia",
            "currencySymbol": "₴",
            "flag": "https://s3.amazonaws.com/rld-flags/ua.svg",
            "callingCodes": [
                "+380"
            ]
        },
        {
            "isoName": "AE",
            "name": "United Arab Emirates",
            "continent": "Asia",
            "currencyCode": "AED",
            "currencyName": "United Arab Emirates Dirham",
            "currencySymbol": "د.إ.‏",
            "flag": "https://s3.amazonaws.com/rld-flags/ae.svg",
            "callingCodes": [
                "+971"
            ]
        },
        {
            "isoName": "GB",
            "name": "United Kingdom",
            "continent": "Europe",
            "currencyCode": "GBP",
            "currencyName": "British Pound Sterling",
            "currencySymbol": "£",
            "flag": "https://s3.amazonaws.com/rld-flags/gb.svg",
            "callingCodes": [
                "+44"
            ]
        },
        {
            "isoName": "US",
            "name": "United States",
            "continent": "North America",
            "currencyCode": "USD",
            "currencyName": "US Dollar",
            "currencySymbol": "$",
            "flag": "https://s3.amazonaws.com/rld-flags/us.svg",
            "callingCodes": [
                "+1"
            ]
        },
        {
            "isoName": "UY",
            "name": "Uruguay",
            "continent": "South America",
            "currencyCode": "UYU",
            "currencyName": "Uruguayan Peso",
            "currencySymbol": "$",
            "flag": "https://s3.amazonaws.com/rld-flags/uy.svg",
            "callingCodes": [
                "+598"
            ]
        },
        {
            "isoName": "UZ",
            "name": "Uzbekistan",
            "continent": "Asia",
            "currencyCode": "UZS",
            "currencyName": "Uzbekistan Som",
            "currencySymbol": "UZS",
            "flag": "https://s3.amazonaws.com/rld-flags/uz.svg",
            "callingCodes": [
                "+998"
            ]
        },
        {
            "isoName": "VU",
            "name": "Vanuatu",
            "continent": "Oceania",
            "currencyCode": "VUV",
            "currencyName": "Vanuatu Vatu",
            "currencySymbol": "VUV",
            "flag": "https://s3.amazonaws.com/rld-flags/vu.svg",
            "callingCodes": [
                "+678"
            ]
        },
        {
            "isoName": "VN",
            "name": "Vietnam",
            "continent": "Asia",
            "currencyCode": "VND",
            "currencyName": "Vietnamese Dong",
            "currencySymbol": "₫",
            "flag": "https://s3.amazonaws.com/rld-flags/vn.svg",
            "callingCodes": [
                "+84"
            ]
        },
        {
            "isoName": "YE",
            "name": "Yemen",
            "continent": "Asia",
            "currencyCode": "YER",
            "currencyName": "Yemeni Rial",
            "currencySymbol": "ر.ي.‏",
            "flag": "https://s3.amazonaws.com/rld-flags/ye.svg",
            "callingCodes": [
                "+967"
            ]
        },
        {
            "isoName": "ZM",
            "name": "Zambia",
            "continent": "Africa",
            "currencyCode": "ZMW",
            "currencyName": "ZMW",
            "currencySymbol": "ZMW",
            "flag": "https://s3.amazonaws.com/rld-flags/zm.svg",
            "callingCodes": [
                "+260"
            ]
        },
        {
            "isoName": "ZW",
            "name": "Zimbabwe",
            "continent": "Africa",
            "currencyCode": "USD",
            "currencyName": "US Dollar",
            "currencySymbol": "$",
            "flag": "https://s3.amazonaws.com/rld-flags/zw.svg",
            "callingCodes": [
                "+263"
            ]
        },
        {
            "isoName": "VE",
            "name": "Venezuela",
            "continent": "South America",
            "currencyCode": "VES",
            "currencyName": "Bolivar soberano",
            "currencySymbol": "Bs. S",
            "flag": "https://s3.amazonaws.com/rld-flags/ve.svg",
            "callingCodes": [
                "+58"
            ]
        },
        {
            "isoName": "GR",
            "name": "Greece",
            "continent": "Europe",
            "currencyCode": "EUR",
            "currencyName": "Euro",
            "currencySymbol": "€",
            "flag": "https://s3.amazonaws.com/rld-flags/gr.svg",
            "callingCodes": [
                "+30"
            ]
        },
        {
            "isoName": "SO",
            "name": "Somalia",
            "continent": "Africa",
            "currencyCode": "USD",
            "currencyName": "US Dollar",
            "currencySymbol": "$",
            "flag": "https://s3.amazonaws.com/rld-flags/so.svg",
            "callingCodes": [
                "+252"
            ]
        },
        {
            "isoName": "BY",
            "name": "Belarus",
            "continent": "Europe",
            "currencyCode": "BYN",
            "currencyName": "Belarusian ruble",
            "currencySymbol": "Br",
            "flag": "https://s3.amazonaws.com/rld-flags/by.svg",
            "callingCodes": [
                "+375"
            ]
        },
        {
            "isoName": "KM",
            "name": "Comoros",
            "continent": "Africa",
            "currencyCode": "KMF",
            "currencyName": "Comorian Franc",
            "currencySymbol": "FC",
            "flag": "https://s3.amazonaws.com/rld-flags/km.svg",
            "callingCodes": [
                "+269"
            ]
        },
        {
            "isoName": "MR",
            "name": "Mauritania",
            "continent": "Africa",
            "currencyCode": "MRU",
            "currencyName": "Mauritanian Ouguiya",
            "currencySymbol": "UM",
            "flag": "https://s3.amazonaws.com/rld-flags/mr.svg",
            "callingCodes": [
                "+222"
            ]
        },
        {
            "isoName": "BE",
            "name": "Belgium",
            "continent": "Europe",
            "currencyCode": "EUR",
            "currencyName": "Euro",
            "currencySymbol": "€",
            "flag": "https://s3.amazonaws.com/rld-flags/be.svg",
            "callingCodes": [
                "+32"
            ]
        },
        {
            "isoName": "MS",
            "name": "Montserrat",
            "continent": "North America",
            "currencyCode": "XCD",
            "currencyName": "East Caribbean Dollar",
            "currencySymbol": "XCD",
            "flag": "https://s3.amazonaws.com/rld-flags/ms.svg",
            "callingCodes": [
                "+1"
            ]
        },
        {
            "isoName": "KR",
            "name": "South Korea",
            "continent": "Asia",
            "currencyCode": "KRW",
            "currencyName": "South Korean Won",
            "currencySymbol": "₩",
            "flag": "https://s3.amazonaws.com/rld-flags/kr.svg",
            "callingCodes": [
                "+82"
            ]
        },
        {
            "isoName": "IR",
            "name": "Iran",
            "continent": "Asia",
            "currencyCode": "IRR",
            "currencyName": "Iranian Rial",
            "currencySymbol": "﷼",
            "flag": "https://s3.amazonaws.com/rld-flags/ir.svg",
            "callingCodes": [
                "+98"
            ]
        },
        {
            "isoName": "GA",
            "name": "Gabon",
            "continent": "Africa",
            "currencyCode": "XAF",
            "currencyName": "CFA Franc BEAC",
            "currencySymbol": "FCFA",
            "flag": "https://s3.amazonaws.com/rld-flags/gab.svg",
            "callingCodes": [
                "+241"
            ]
        },
        {
            "isoName": "AT",
            "name": "Austria",
            "continent": "Europe",
            "currencyCode": "EUR",
            "currencyName": "Euro",
            "currencySymbol": "€",
            "flag": "https://s3.amazonaws.com/rld-flags/at.svg",
            "callingCodes": [
                "+43"
            ]
        },
        {
            "isoName": "IE",
            "name": "Ireland",
            "continent": "Europe",
            "currencyCode": "EUR",
            "currencyName": "Euro",
            "currencySymbol": "€",
            "flag": "https://s3.amazonaws.com/rld-flags/ie.svg",
            "callingCodes": [
                "+353"
            ]
        },
        {
            "isoName": "LU",
            "name": "Luxembourg",
            "continent": "Europe",
            "currencyCode": "EUR",
            "currencyName": "Euro",
            "currencySymbol": "€",
            "flag": "https://s3.amazonaws.com/rld-flags/lu.svg",
            "callingCodes": [
                "+352"
            ]
        },
        {
            "isoName": "CH",
            "name": "Switzerland",
            "continent": "Europe",
            "currencyCode": "CHF",
            "currencyName": "Swiss franc",
            "currencySymbol": "CHF",
            "flag": "https://s3.amazonaws.com/rld-flags/ch.svg",
            "callingCodes": [
                "+41"
            ]
        },
        {
            "isoName": "LT",
            "name": "Lithuania",
            "continent": "Europe",
            "currencyCode": "EUR",
            "currencyName": "Euro",
            "currencySymbol": "€",
            "flag": "https://s3.amazonaws.com/rld-flags/lt.svg",
            "callingCodes": [
                "+370"
            ]
        },
        {
            "isoName": "AZ",
            "name": "Azerbaijan",
            "continent": "Europe",
            "currencyCode": "AZN",
            "currencyName": "Azerbaijani Manat",
            "currencySymbol": "ман.",
            "flag": "https://s3.amazonaws.com/rld-flags/az.svg",
            "callingCodes": [
                "+994"
            ]
        },
        {
            "isoName": "TM",
            "name": "Turkmenistan",
            "continent": "Europe",
            "currencyCode": "TMT",
            "currencyName": "Turkmenistani manat",
            "currencySymbol": "TMT",
            "flag": "https://s3.amazonaws.com/rld-flags/tm.svg",
            "callingCodes": [
                "+993"
            ]
        },
        {
            "isoName": "IL",
            "name": "Israel",
            "continent": "Asia",
            "currencyCode": "ILS",
            "currencyName": "Israeli New Sheqel",
            "currencySymbol": "₪",
            "flag": "https://s3.amazonaws.com/rld-flags/il.svg",
            "callingCodes": [
                "+972"
            ]
        }
        ]';
}