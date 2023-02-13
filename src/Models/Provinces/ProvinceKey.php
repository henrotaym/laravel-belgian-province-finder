<?php
namespace Henrotaym\LaravelBelgianProvinceFinder\Models\Provinces;

enum ProvinceKey: string
{
    case WEST_FLANDERS = "west-flanders";
    case EAST_FLANDERS = "east-flanders";
    case ANTWERP = "antwerp";
    case LIMBURG = "limburg";
    case FLEMISH_BRABANT = "flemish-brabant";
    case BRUSSELS_CAPITAL_REGION = "brussels-capital-region";
    case WALLOON_BRABANT = "walloon-brabant";
    case HAINAUT = "hainaut";
    case NAMUR = "namur";
    case LIEGE = "liege";
    case LUXEMBOURG = "luxembourg";
}