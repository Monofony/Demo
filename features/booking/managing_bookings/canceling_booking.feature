@managing_bookings
Feature: Canceling booking
    In order to cancel a booking
    As an Administrator
    I want to cancel a booking

    Background:
        Given animals are classified under "Cats" and "Dogs" categories
        And there is an animal with name "Kitty"
        And this animal belongs to "Cats"
        And this animal has been booked by customer "cruella@101dalamatiens.com"
        And I am logged in as an administrator

    @ui @email
    Scenario: Canceling booking
        Given I want to cancel this booking
        When I cancel it
        And the email with reset token should be sent to "cruella@101dalamatiens.com"
        Then this booking should be canceled
