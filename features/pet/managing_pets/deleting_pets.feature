@managing_pets
Feature: Deleting a pet
    In order to get rid of deprecated pets
    As an Administrator
    I want to be able to delete a pet

    Background:
        Given I am logged in as an administrator
        And pets are classified under "Axolotls" and "Dogs" categories
        And there is a pet with name "Homer"
        And this pet belongs to "Axolotls"
        And there is a pet with name "Poivron"
        And this pet belongs to "Dogs"

    @ui
    Scenario: Deleting a pet
        Given I want to see all pets
        When I delete pet with name "Homer"
        Then I should be notified that it has been successfully deleted
        And there should not be "Axolotl" pet anymore
