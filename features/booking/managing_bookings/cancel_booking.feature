@managing_bookings
Feature: Cancel booking
    In order to cancel a booking
    As an Administrator
    I want to cancel a booking and see the pet state should be bookable

    Background:
        Given pets are classified under "Cats" and "Dogs" categories
        And there is a pet with name "Kitty"
        And this pet belongs to "Cats"
        And this pet is bookable
        And this pet has been booked by customer "cruella@101dalamatiens.com"
        And this booking has a scheduled visit
        And I am logged in as an administrator

    @ui
    Scenario: Cancel booking
        Given I want to cancel this booking
        When I cancel it
        Then this booking should be canceled
        And this pet should be bookable
