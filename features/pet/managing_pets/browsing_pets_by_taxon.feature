@managing_pets
Feature: Browsing animals
    In order to see all animals
    As an Administrator
    I want to browse animals

    Background:
        Given pets are classified under "Axolotls" and "Dogs" categories
        And there is a pet with name "Homer"
        And this pet belongs to "Axolotls"
        And there is a pet with name "Tom"
        And this pet belongs to "Dogs"
        And I am logged in as an administrator

    @ui
    Scenario: Browsing only pets from specified category
        Given I want to see all pets
        When I filter them by "Dogs" taxon
        Then I should see the pet "Tom" in the list
        But I should not see any pet with name "Homer"
