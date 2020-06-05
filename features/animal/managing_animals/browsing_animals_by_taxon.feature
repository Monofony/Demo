@managing_animals
Feature: Browsing animals
    In order to see all animals
    As an Administrator
    I want to browse animals

    Background:
        Given animals are classified under "Axolotls" and "Dogs" categories
        And there is an animal with name "Homer"
        And this animal belongs to "Axolotls"
        And there is an animal with name "Tom"
        And this animal belongs to "Dogs"
        And I am logged in as an administrator

    @ui
    Scenario: Browsing only animals from specified category
        Given I want to see all animals
        When I filter them by "Dogs" taxon
        Then I should see the animal "Tom" in the list
        But I should not see any animal with name "Homer"
