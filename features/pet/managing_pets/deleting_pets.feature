@managing_pets
Feature: Deleting a pet
    In order to get rid of deprecated pets
    As an Administrator
    I want to be able to delete a pet

    Background:
        Given there is a default locale
        And there is a pet with name "Homer"
        And there is a pet with name "Poivron"
        And I am logged in as an administrator

    @ui
    Scenario: Deleting a pet
        Given I am browsing pets
        When I delete pet with name "Homer"
        Then I should be notified that it has been successfully deleted
        And there should not be "Axolotl" pet anymore
