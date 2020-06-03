@managing_bookings
Feature: Validating booking
    In order to validate a booking
    As an Administrator
    I want to validate a booking

    Background:
        Given animals are classified under "Cats" and "Dogs" categories
        And there is a pet with name "Kitty"
        And this pet belongs to "Cats"
        And this pet has been booked by customer "cruella@101dalamatiens.com"
        And I am logged in as an administrator

    @ui
    Scenario: Validating booking
        Given I want to validate this booking
        When I validate it
        Then this booking should be validated
