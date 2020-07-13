@managing_bookings
Feature: Contacting family
    In order to contact family
    As an Administrator
    I want to contact family for a booking

    Background:
        Given pets are classified under "Cats" and "Dogs" categories
        And there is a pet with name "Kitty"
        And this pet belongs to "Cats"
        And this pet has been booked by customer "cruella@101dalamatiens.com"
        And I am logged in as an administrator

    @ui
    Scenario: Contact family booking
        Given I want to contact family for this booking
        When I contact family for it
        Then this booking required contact with the family
