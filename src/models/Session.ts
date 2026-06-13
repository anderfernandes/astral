import {
  CreationOptional,
  DataTypes,
  InferAttributes,
  InferCreationAttributes,
  Model,
} from "@sequelize/core";
import {
  Attribute,
  NotNull,
  PrimaryKey,
} from "@sequelize/core/decorators-legacy";

export class Session extends Model<
  InferAttributes<Session>,
  InferCreationAttributes<Session>
> {
  @Attribute(DataTypes.STRING)
  @PrimaryKey
  declare id: string;

  @Attribute(DataTypes.INTEGER)
  @NotNull
  declare userId: number;

  @Attribute(DataTypes.DATE)
  @NotNull
  declare createdAt: Date;

  @Attribute(DataTypes.DATE)
  @NotNull
  declare expiresAt: Date;
}
