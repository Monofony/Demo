@managing_taxons
Feature: Editing a taxon
    In order to change information about a taxon
    As an Administrator
    I want to be able to edit the taxon

    Background:
        Given I am logged in as an administrator
        And there is a taxon with name "Cats"

    @ui
    Scenario: Renaming an existing taxon
        When I want to edit this taxon
        And I change its name to "Pogba"
        And I save my changes
        Then I should be notified that it has been successfully edited
        And the taxon "Pogba" should appear in the list
