import {
  CreationOptional,
  DataTypes,
  InferAttributes,
  InferCreationAttributes,
  Model,
} from "@sequelize/core";
import {
  Attribute,
  AutoIncrement,
  CreatedAt,
  Default,
  NotNull,
  PrimaryKey,
  Table,
  UpdatedAt,
} from "@sequelize/core/decorators-legacy";

@Table({ timestamps: false })
export class PaymentMethod extends Model<
  InferAttributes<PaymentMethod>,
  InferCreationAttributes<PaymentMethod>
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

  @Attribute(DataTypes.STRING)
  @NotNull
  declare type: "CASH" | "CARD" | "CHECK" | "OTHER";

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
