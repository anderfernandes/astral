import {
  CreationOptional,
  InferAttributes,
  InferCreationAttributes,
  DataTypes,
  Model,
} from "@sequelize/core";

import {
  Attribute,
  PrimaryKey,
  AutoIncrement,
  NotNull,
  Table,
} from "@sequelize/core/decorators-legacy";

@Table({ timestamps: false })
export class MembershipType extends Model<
  InferAttributes<MembershipType>,
  InferCreationAttributes<MembershipType>
> {
  @Attribute(DataTypes.INTEGER)
  @PrimaryKey
  @AutoIncrement
  declare id: CreationOptional<number>;

  @Attribute(DataTypes.STRING)
  @NotNull
  declare name: string;

  @Attribute(DataTypes.STRING)
  @NotNull
  declare description: string;

  @Attribute(DataTypes.INTEGER)
  @NotNull
  declare duration: number;

  @Attribute(DataTypes.INTEGER)
  @NotNull
  declare price: number;

  @Attribute(DataTypes.INTEGER)
  @NotNull
  declare maxFreeSecondaries: number;

  @Attribute(DataTypes.INTEGER)
  @NotNull
  declare maxPaidSecondaries: number;

  @Attribute(DataTypes.INTEGER)
  @NotNull
  declare paidSecondaryPrice: number;

  @Attribute(DataTypes.BOOLEAN)
  @NotNull
  declare isActive: boolean;

  @Attribute(DataTypes.BOOLEAN)
  @NotNull
  declare isPublic: boolean;

  @Attribute(DataTypes.DATE)
  @NotNull
  declare createdAt: Date;

  @Attribute(DataTypes.DATE)
  declare updatedAt: CreationOptional<Date>;
}
