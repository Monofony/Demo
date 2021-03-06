@managing_pets
Feature: Adding a new pet with images
    In order to create new pet
    As an Administrator
    I want to add a pet to the list

    Background:
        Given I am logged in as an administrator
        And there is a taxon with name "Amphibie"

    @ui @javascript
    Scenario: Adding a new pet with images
        Given I want to create a new pet
        When I specify its name as "Axolotl"
        And I specify its taxon as "Amphibie"
        And I attach the "pets/Axolotl.jpg" image
        And I add it
        Then I should be notified that it has been successfully created
        And the pet "Axolotl" should have one image
