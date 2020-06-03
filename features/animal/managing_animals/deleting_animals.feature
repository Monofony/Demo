@managing_animals
Feature: Deleting an animal
    In order to get rid of deprecated animals
    As an Administrator
    I want to be able to delete an animal

    Background:
        Given I am logged in as an administrator
        And animals are classified under "Axolotls" and "Dogs" categories
        And there is a pet with name "Homer"
        And this animal belongs to "Axolotls"
        And there is a pet with name "Poivron"
        And this animal belongs to "Dogs"

    @ui
    Scenario: Deleting an animal
        Given I want to see all animals
        When I delete animal with name "Homer"
        Then I should be notified that it has been successfully deleted
        And there should not be "Axolotl" animal anymore
