@managing_bookings
Feature: Cancel booking
    In order to cancel a booking
    As an Administrator
    I want to cancel a booking

    Background:
        Given animals are classified under "Cats" and "Dogs" categories
        And there is an animal with name "Kitty"
        And this animal belongs to "Cats"
        And this animal has been booked by customer "cruella@101dalamatiens.com"
        And I am logged in as an administrator

    @ui
    Scenario: Cancel booking
        Given I want to cancel this booking
        When I cancel it
        And the email with reset token should be sent to "demo-monofony-5b6e94@inbox.mailtrap.io"
        Then I should see this booking has been canceled in the list
