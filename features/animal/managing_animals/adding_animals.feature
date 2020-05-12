@managing_animals
Feature: Adding a new animal
  In order to create new animal
  As an Administrator
  I want to add a animal to the store

  Background:
    Given I am logged in as an administrator

  @ui
  Scenario: Adding a new animal
    Given I want to create a new animal
    When I specify its name as "Axolotl"
    And I specify its slug as "Axolotl"
    And I add it
    Then I should be notified that it has been successfully created
    And the animal "Axolotl" should appear in the store