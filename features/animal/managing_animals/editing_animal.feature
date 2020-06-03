@managing_animals
Feature: Editing an animal
    In order to change information about an animal
    As an Administrator
    I want to be able to edit the animal

    Background:
        Given I am logged in as an administrator
        And animals are classified under "Axolotls" and "Dogs" categories
        And there is a pet with name "Homer"
        And this animal belongs to "Axolotls"

    @ui
    Scenario: Renaming an existing animal
        When I want to edit this animal
        And I change its name to "Pangolin"
        And I save my changes
        Then I should be notified that it has been successfully edited
        And the animal "Pangolin" should appear in the list
