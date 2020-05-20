@managing_animals
Feature: Deleting an animal
    In order to get rid of deprecated animals
    As an Administrator
    I want to be able to delete an animal

    Background:
        Given I am logged in as an administrator
        And there is an animal with name "Axolotl"
        And there is an animal with name "Poivron"

    @ui
    Scenario: Deleting an animal
        Given I want to see all animals
        When I delete animal with name "Axolotl"
        Then I should be notified that it has been successfully deleted
        And there should not be "Axolotl" animal anymore
