// See https://kit.svelte.dev/docs/types#app
// for information about these interfaces
declare global {
	namespace App {
		// interface Error {}
		// interface Locals {}
		// interface PageData {}
		// interface PageState {}
		// interface Platform {}
	}

	interface IContext {
		toasts: IToastContext;
	}

	interface IToastContext {
		toasts: {
			title?: string | undefined;
			message: string;
		}[];
		push: (t: { title?: string | undefined; message: string }) => void;
	}

	interface IResponseWithValidationErrors extends Record<string, undefined> {
		message: string;
		errors: Record<string, string[]>;
	}

	interface IResponseWithErrors {
		message: string;
		file: string;
		line: number;
	}

	interface ISettings {
		organization: {
			name: string;
			address: string;
			phone: string;
			fax: string;
			email: string;
			website: string;
			seats: number;
			logo: string;
			cover: string;
			tax: number;
			astc: boolean;
			logo: string;
		};
		version: string;
		timezone: string;
		upload_max_filesize: string;
		extensions: string[];
		memory_limit: string;
		other: string;
	}

	/**
	 * Organization.
	 */
	interface IOrganization extends IBasicFields {
		name: string;
	}

	interface ISaleMemo extends IBasicFields {
		author_id: number;
		author: IUser;
		message: string;
	}

	/**
	 * Sale.
	 */
	interface ISale extends IBasicFields {
		products: IProduct[];
		tickets: ITicket[];
		subtotal: number;
		tax: number;
		total: number;
		tendered: number;
		change: number;
		customer_id: number;
		status: string;
		payments: IPayment[];
		customer?: IUser;
		source: string;
		taxable: boolean;
		refund: boolean;
		organization_id: number;
		organization?: IOrganization;
		sell_to_organization: false;
		balance: number;
		creator_id: number;
		creator?: IUser;
		memos: ISaleMemo[];
		events?: IEvent[];
	}

	/**
	 * Ticket Type
	 */
	interface ITicketType extends IBasicFields {
		name: string;
		description: string;
		is_active: boolean;
		price: number;
		in_cashier: boolean;
		is_public: boolean;
	}

	interface ITicketWithQuantity extends ITicket {
		quantity: number;
	}

	interface IProductWithQuantity extends IProduct {
		quantity: number;
	}

	/**
	 * Event Type
	 */
	interface IEventType extends IBasicFields {
		name: string;
		description?: string;
		creator_id?: number;
		color?: string;
		is_public?: boolean;
		allowed_tickets: ITicketType[];
	}

	/**
	 * Show Type
	 */
	interface IShowType extends IBasicFields {
		name: string;
		description: string;
		is_active: boolean;
		creator_id?: number;
	}

	/**
	 * Product Type
	 */
	interface IProductType extends IBasicFields {
		name: string;
		description: string;
		creator_id: number;
	}

	/**
	 * Ticket.
	 */
	interface ITicket extends IBasicFields {
		event_id: number;
		event?: IEvent;
		sale_id?: number;
		//sale?: ISale;
		customer_id: number;
		customer?: IUser;
		cashier_id?: number;
		cashier?: IUser;
		type_id: number;
		type: ITicketType;
		organization_id?: number;
	}

	/**
	 * Product
	 */
	interface IProduct extends IBasicFields {
		name: string;
		price: number;
		type_id: number;
		type?: IProductType;
		description: string;
		inventory: boolean;
		stock: number;
		cover: string;
		is_active: boolean;
		is_public: boolean;
		in_cashier: boolean;
	}

	interface IEvent extends IBasicFields {
		start: string;
		end: string;
		memos: IEventMemo[]; // create a different request for this?
		show_id: number | undefined;
		show: IShow;
		// shows: IShow[] // one event can have many shows
		seats: { available: number; taken: number; total: number };
		creator_id: number;
		//creator: IUser,
		type_id: number | undefined;
		type: IEventType;
		is_public: boolean;
		is_all_day: boolean;
		title?: string | null;
		tickets: ITicket[];
		products: IProduct[];
	}

	/**
	 * Event type
	 */
	interface IEventType extends IBasicFields {
		name: string;
		description?: string;
		creator_id?: number;
		color?: string;
		public?: boolean;
		allowed_tickets: ITicketType[];
	}

	/**
	 * `IShowType`
	 */
	interface IShowType {
		name: string;
	}

	/**
	 * `IEventMemo`
	 */
	interface IEventMemo extends IBasicFields {
		message: string;
		author: IUser;
	}

	/**
	 * Show
	 */
	interface IShow extends IBasicFields {
		name: string;
		duration: number;
		description: string;
		cover: string;
		creator_id?: number;
		type_id: number;
		is_active?: boolean;
		trailer_url: string | null;
		expiration: string | null;
		type?: IShowType | undefined;
		is_expired: boolean;
	}

	/**
	 * The base properties in all Astral objects.
	 */
	interface IBasicFields {
		id?: number;
		created_at: string; // TODO: Change to date
		updated_at: string; // TODO: Change to date
	}

	/**
	 * User role
	 */
	interface IRole extends IBasicFields {
		name: string;
		staff: boolean;
	}

	/**
	 * Membership
	 */
	interface IMembership extends IBasicFields {
		type_id: number;
		creator_id: number;
		start: string;
		end: string;
		primary_id: number;
		number: string;
		is_expired: boolean;
		primary: IUser;
		secondaries: IUser[];
		type: IMembershipType;
	}

	/**
	 * An Astral user account.
	 */
	interface IUser extends IBasicFields {
		name?: string;
		firstname: string;
		lastname: string | null;
		email: string;
		role_id: number;
		role: IRole;
		active?: boolean;
		membership_id?: number;
		type?: 'walk-up' | 'organization' | 'individual';
		organization_id?: number;
		address: string | null;
		city: string | null;
		state: string | null;
		zip: string | null;
		country: string;
		phone: string | null;
		staff: boolean | null;
		creator_id: number;
		newsletter: boolean;
		membership: IMembership;
	}

	interface IMembershipType extends IBasicFields {
		name: string;
		description: string;
		price: number;
		duration: number;
		max_secondaries: number;
		secondary_price: number;
		is_active: boolean;
		keep_remaining_days: boolean;
	}

	interface IOrganizationType extends IBasicFields {
		name: string;
		description: string;
		taxable: boolean;
	}

	interface IOrganization extends IBasicFields {
		name: string;
		address: string;
		city: string;
		state: string;
		zip: string;
		country: string;
		phone: string;
		fax: string;
		email: string;
		website: string | null;
		type_id: number;
		type?: IOrganizationType;
		users: IUser[];
	}

	/**
	 * Payment method.
	 */
	interface IPaymentMethod extends IBasicFields {
		name: string;
		description: string;
		icon: string;
		type: 'cash' | 'card' | 'check' | 'online';
		creator_id: number;
	}

	interface ITicketWithQuantity extends Required<Pick<ITicket, 'event' | 'type'>> {
		quantity: number;
	}

	interface IProductWithQuantity extends IProduct {
		quantity: number;
	}

	/**
	 * ISaleItems
	 */
	interface ISaleItems {
		tickets: CartTicket[];
		products: CartProduct[];
	}

	/**
	 * ISaleTotals
	 */
	interface ISaleTotals {
		subtotal: number;
		tax: number;
		total: number;
		change: number;
		tendered: number;
		payments: { method_id: number; tendered: number }[];
	}

	/**
	 * Payment
	 */
	interface IPayment extends IBasicFields {
		cashier_id: number;
		payment_method_id: 1;
		method: IPaymentMethod;
		total: number;
		tendered: number;
		change_due: number;
		reference: string;
		source: string;
		sale_id: number;
		cashier: IUser;
		refunded: boolean;
	}
}

export {};
