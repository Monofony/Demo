@managing_taxons
Feature: Adding a new taxon
    In order to extend taxonomy database
    As an Administrator
    I want to add a new taxon to the website

    Background:
        Given I am logged in as an administrator

    @ui
    Scenario: Adding a new taxon with name and slug
        Given I want to create a new taxon
        And I specify its code as "CAT"
        And I specify its name as "Cats"
        And I specify its slug as "cats"
        When I add it
        Then I should be notified that it has been successfully created
        And the taxon "Cats" should appear in the list
