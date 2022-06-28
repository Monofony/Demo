@booking_pets
Feature: Booking a pet for a visit
    In order to book a pet for a visit
    As a customer
    I want to be able to ask a visit for a pet

    Background:
        Given there is a default locale
        And pets are classified under "Cats" and "Dogs" categories
        And there is a pet with name "Gizmo"
        And this pet belongs to "Dogs"
        And this pet is bookable
        And there is a user "francis@underwood.com" identified by "whitehouse"

    @ui
    Scenario: Booking a pet for a visit as a logged user
        When I am logged in as "francis@underwood.com"
        And I want to ask for a visit this pet
        And I confirm my choice
        Then the pet "Gizmo" has been booked

    @ui
    Scenario: Trying to book a pet for a visit as a visitor
        When I try to ask for a visit this pet
        Then I should be redirected to login page
