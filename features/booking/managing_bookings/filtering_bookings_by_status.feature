@managing_bookings
Feature: Filtering inventory by code
    In order to filter tracked product variants by code
    As an Administrator
    I want to be able to filter tracked product variants on the list

    Background:
        Given pets are classified under "Cats" and "Dogs" categories
        And there is a pet with name "Kitty"
        And this pet belongs to "Cats"
        And this pet has been booked by customer "cruella@101dalamatiens.com"
        And there is a pet with name "Garfield"
        And this pet belongs to "Cats"
        And this pet has been booked by customer "cruella@101dalamatiens.com"
        And there is a pet with name "Tom"
        And this pet belongs to "Dogs"
        And this pet has been booked by customer "cruella@101dalamatiens.com"
        And this booking has been canceled
        And I am logged in as an administrator

    @ui
    Scenario: Filtering bookings by status
        When I want to see all bookings
        And I filter bookings with status "New"
        Then I should see 2 bookings in the list
