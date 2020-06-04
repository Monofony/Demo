@managing_bookings
Feature: Browsing bookings
    In order to see all bookings
    As an Administrator
    I want to browse bookings

    Background:
        Given animals are classified under "Cats" and "Dogs" categories
        And there is a pet with name "Kitty"
        And this pet belongs to "Cats"
        And this pet has been booked by customer "cruella@101dalamatiens.com"
        And I am logged in as an administrator

    @ui
    Scenario: Browsing bookings
        When I want to see all bookings
        Then I should see 1 bookings in the list
        And I should see the booking for the pet "Kitty" in the list
