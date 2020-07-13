@managing_pets
Feature: Validate pet
    In order to validate a pet
    As an Administrator
    I want to validate a pet

    Background:
        Given pets are classified under "Cats" and "Dogs" categories
        And there is a pet with name "Kitty"
        And this pet belongs to "Cats"
        And this pet is a new pet
        And I am logged in as an administrator

    @ui
    Scenario: Validate pet
        Given I want to validate this pet
        When I validate it
        Then I should see the pet has been validated in the list
