@viewing_pets
Feature: Asking for a visit for a pet
    In order to ask a visit for a pet
    As a customer
    I want to be able to ask a visit for a pet

    Background:
        Given pets are classified under "Cats" and "Dogs" categories
        And there is a pet with name "Gizmo"
        And this pet belongs to "Dogs"
        And this pet is bookable
        And there is a user "francis@underwood.com" identified by "whitehouse"

    @ui
    Scenario: Asking for a visit for a pet as a logged user
        Given I am logged in as "francis@underwood.com"
        And I want to ask for a visit this pet
        And I confirm my choice
        And I should see my request has been send
        Then the pet "Gizmo" has been booked

    @ui
    Scenario: Trying to ask for a visit for a pet as a visitor
        Given I try to ask for a visit this pet
        And I should be redirected to login page
