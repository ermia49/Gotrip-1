# Vehicle Classification System

## Overview
This guide documents the comprehensive 5-tier vehicle classification system used to automatically categorize vehicles and display appropriate content on single vehicle pages.

---

## Classification Categories

### 1. **Luxury Sedan** (`luxury`)
**Overview Content:** Executive luxury transportation with premium features, handcrafted interiors, VIP service

**Detected by:**
- **Luxury Keywords:** Premium Sedan, Luxury, First Class, Executive, Business Class
- **Luxury Models:** 
  - Mercedes: S-Class, E-Class
  - BMW: 5 Series, 7 Series, 8 Series
  - Audi: A6, A7, A8
  - Other: Lexus, Porsche, Bentley, Rolls-Royce
- **NOT Economy/Standard Brands**

**Example Vehicles:**
- Mercedes S-Class
- BMW 7 Series
- Audi A8
- Premium Sedan
- Executive Sedan

**Key Features in Content:**
- Handcrafted leather interiors
- VIP airport transfers
- Executive business meetings
- Privacy and discretion
- Professional chauffeur excellence

---

### 2. **Luxury Van** (`luxury-van`)
**Overview Content:** Premium executive group transportation with first-class amenities

**Detected by:**
- **Is Van:** 7+ passengers OR contains "van", "bus", "minibus", "sprinter", "vito"
- **AND Luxury:** Has luxury keywords OR luxury models
- **NOT Economy/Standard Brands**

**Example Vehicles:**
- First Class Van
- Mercedes V-Class
- Premium Sprinter
- Executive Van
- Luxury Minibus

**Key Features in Content:**
- Individual climate controls
- Premium entertainment systems
- Executive-grade amenities
- VIP group transfers
- Corporate executive travel
- Luxury tours and special events

---

### 3. **Standard Van** (`van`)
**Overview Content:** Comfortable, reliable group transportation with modern amenities

**Detected by:**
- **Is Van:** 7+ passengers OR contains "van", "bus", "minibus", "sprinter", "vito"
- **NOT Luxury:** No luxury keywords or models

**Example Vehicles:**
- Passenger Van
- Standard Minibus
- 12-Passenger Van
- Group Van
- Mercedes Vito (standard)

**Key Features in Content:**
- Spacious seating for groups
- Ample luggage capacity
- Cost-effective group travel
- Airport transfers and tours
- Family vacations and corporate events
- Safety and reliability focus

---

### 4. **Economy Sedan** (`economy`) ⭐ NEW
**Overview Content:** Affordable, budget-friendly transportation with essential features

**Detected by:**
- **Economy Brands:** VW, Toyota, Honda, Ford, Opel, Skoda, Seat, Hyundai, Kia, Nissan, Mazda, Peugeot, Renault, Citroen, Dacia, Fiat
- **NOT Van:** Less than 7 passengers AND no van keywords
- **NOT Luxury:** No luxury keywords or models

**Example Vehicles:**
- Volkswagen Passat ✓
- Toyota Camry
- Honda Accord
- VW Golf
- Opel Insignia
- Ford Mondeo
- Skoda Octavia

**Key Features in Content:**
- Budget-friendly rates
- Essential comfort features
- Student & youth travel
- Cost-effective business travel
- Affordable airport transfers
- Best value for money

---

### 5. **Standard Sedan** (`standard`)
**Overview Content:** Reliable, comfortable mid-range transportation with excellent value

**Detected by:**
- **Standard Brands:** Volvo, Alfa Romeo, Infiniti, Acura, Buick, Chrysler
- **NOT Van:** Less than 7 passengers AND no van keywords
- **NOT Luxury:** No luxury keywords or models
- **NOT Economy:** Not budget brands

**Example Vehicles:**
- Volvo S60
- Alfa Romeo Giulia
- Infiniti Q50
- Acura TLX

**Key Features in Content:**
- Dependable transportation
- Modern amenities
- Excellent value
- Professional service
- Business and leisure travel
- Mid-range comfort

---

## Detection Logic Flow

```
1. Is it a VAN? (7+ passengers OR van/bus/minibus/sprinter/vito in name)
   ├─ YES → Is it LUXURY? (luxury keywords OR luxury models) AND NOT economy/standard brand?
   │   ├─ YES → LUXURY VAN (First Class Van, V-Class)
   │   └─ NO → STANDARD VAN (Passenger Van, Minibus)
   │
   └─ NO → Is it LUXURY? (luxury keywords OR luxury models) AND NOT economy/standard brand?
       ├─ YES → LUXURY SEDAN (S-Class, BMW 7, Audi A8)
       ├─ NO → Is it ECONOMY brand?
       │   ├─ YES → ECONOMY SEDAN (VW Passat, Toyota Camry)
       │   └─ NO → STANDARD SEDAN (Volvo, Alfa Romeo)
```

---

## Economy Brands (Budget-Friendly)

These brands are **always** classified as economy, emphasizing affordability:

- Volkswagen / VW
- Toyota
- Honda
- Ford
- Opel
- Skoda
- Seat
- Hyundai
- Kia
- Nissan
- Mazda
- Peugeot
- Renault
- Citroen
- Dacia
- Fiat

---

## Standard Brands (Mid-Range)

These brands are classified as standard (between economy and luxury):

- Volvo
- Alfa Romeo
- Infiniti
- Acura
- Buick
- Chrysler

---

## Luxury Brands/Models (Always Luxury if not standard brand)

### Luxury Keywords:
- Premium Sedan
- Luxury
- First Class / First-Class
- Executive
- Business Class

### Luxury Car Models:
- **Mercedes:** S-Class, E-Class, V-Class
- **BMW:** 5 Series, 7 Series, 8 Series
- **Audi:** A6, A7, A8
- **Ultra-Luxury:** Lexus, Porsche, Bentley, Rolls-Royce

---

## Van Detection Keywords

A vehicle is considered a van if it has:
- **7 or more passengers**
- OR contains any of these keywords:
  - van
  - bus
  - minibus
  - sprinter
  - vito

---

## Content Customization by Category

Each category displays tailored, SEO-optimized content:

| Category | Focus | Tone | Key Benefits |
|----------|-------|------|--------------|
| **Luxury Sedan** | Executive prestige | Sophisticated, exclusive | VIP service, discretion, premium comfort |
| **Luxury Van** | First-class group travel | Premium, executive | Executive amenities, VIP groups, luxury tours |
| **Standard Van** | Group value & comfort | Professional, practical | Cost-effective, spacious, reliable |
| **Economy Sedan** | Budget-friendly value | Friendly, accessible | Affordable rates, student travel, best prices |
| **Standard Sedan** | Mid-range comfort | Professional, balanced | Reliable, modern amenities, good value |

---

## Testing Your Vehicles

To verify classification:

1. **Check vehicle title** - Does it contain luxury keywords or economy/standard brands?
2. **Check passenger count** - Is it 7+ (van) or less (sedan)?
3. **Apply logic flow** - Follow the decision tree above
4. **View single vehicle page** - Overview content should match the category

### Quick Test Cases:

✅ **"Mercedes S-Class"** → Luxury Sedan (luxury model, not van)  
✅ **"First Class Van"** → Luxury Van (luxury keyword + van)  
✅ **"Passenger Van"** → Standard Van (van, no luxury)  
✅ **"Volkswagen Passat"** → Economy Sedan (economy brand) ⭐  
✅ **"BMW 7 Series"** → Luxury Sedan (luxury model)  
✅ **"Mercedes V-Class"** → Luxury Van (luxury model + van/7+ passengers)  
✅ **"Toyota Camry"** → Economy Sedan (economy brand)  
✅ **"Volvo S60"** → Standard Sedan (standard/mid-range brand)  

---

## File Location

Classification logic: `/app/public/wp-content/themes/gotriptoday/single-cars.php` (lines 568-637)

---

## Maintenance Notes

- Add new luxury brands to `$luxury_models` variable
- Add new standard brands to `$standard_brand` variable
- Van detection uses both passenger count (7+) and keywords
- Standard brands **always** override luxury keywords
- Content sections are at lines 640-760 in `single-cars.php`

---

**Last Updated:** October 29, 2025  
**Status:** ✅ Comprehensive classification system active

